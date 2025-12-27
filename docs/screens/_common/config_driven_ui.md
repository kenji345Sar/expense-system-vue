# 設定駆動型 UI アーキテクチャ仕様

---

## 目的

本ドキュメントは、経費精算システムにおける「設定駆動型 UI（Config-Driven UI）」の仕組みを説明します。
`config/expense_headers.php` を単一の設定ソースとして、一覧画面とフォーム画面の両方で動的に UI を生成する設計思想と実装詳細を明確化します。

---

## 設計思想

### 設定駆動型 UI とは

**1つの設定ファイル（expense_headers.php）から、複数の画面要素を自動生成する仕組み**

- **一覧画面（index）**：テーブルの列定義として使用
- **フォーム画面（create/edit）**：入力フィールド定義として使用（一部除外）
- **データ表示**：フォーマッタによる整形（金額→円表示、ステータス→日本語ラベルなど）

### メリット

1. **単一情報源（Single Source of Truth）**
   - フィールド定義が1箇所に集約され、メンテナンス性向上
   - 列追加・削除時の変更箇所が最小化

2. **DRY 原則の徹底**
   - 一覧・フォーム・バリデーション・フォーマットの定義を重複させない

3. **柔軟な拡張性**
   - 新しい経費種別追加時、config に定義を追加するだけで UI が自動生成される

---

## config/expense_headers.php の構造

### ファイル概要

**パス**: `config/expense_headers.php`

**役割**: 全経費種別のフィールド定義を集約

### 設定項目の構造

各経費種別（transportation, supplies, business_trip, entertainment）ごとに、以下の構造で定義します：

```php
return [
  'transportation' => [
    ['key' => 'id', 'label' => 'ID', 'source' => 'expense', 'required' => true],
    ['key' => 'user.name', 'label' => '申請者', 'source' => 'expense', 'required' => true],
    ['key' => 'use_date', 'label' => '利用日', 'source' => 'detail', 'formatter' => 'date', 'type' => 'date', 'required' => true],
    ['key' => 'departure', 'label' => '出発地', 'source' => 'detail', 'required' => true],
    ['key' => 'arrival', 'label' => '到着地', 'source' => 'detail', 'required' => true],
    ['key' => 'route', 'label' => '経路', 'source' => 'detail', 'required' => true],
    ['key' => 'amount', 'label' => '金額', 'source' => 'expense', 'formatter' => 'yen', 'type' => 'number', 'required' => true],
    ['key' => 'status', 'label' => 'ステータス', 'source' => 'expense', 'formatter' => 'status', 'required' => false],
  ],
  // 他の種別も同様...
];
```

### フィールド定義の各属性

| 属性 | 必須 | 説明 | 例 |
|------|------|------|-----|
| `key` | ○ | データのキー名（ドット記法可） | `'user.name'`, `'amount'` |
| `label` | ○ | 画面表示用ラベル | `'申請者'`, `'金額'` |
| `source` | ○ | データの取得元（`expense` or `detail`） | `'expense'`, `'detail'` |
| `formatter` | - | 表示フォーマッタ（後述） | `'yen'`, `'date'`, `'status'` |
| `type` | - | 入力タイプ（フォーム用） | `'date'`, `'number'`, `'text'` |
| `required` | ○ | 必須フィールドかどうか | `true`, `false` |

#### `source` の意味

- **`expense`**: `expenses` テーブルから直接取得（id, user_id, amount, status など）
- **`detail`**: 明細テーブル（transportation_expenses, supplies など）から取得

---

## 画面別の使われ方

### 1. 一覧画面（index）での使用

#### データフロー

```
config/expense_headers.php
  ↓ (Controller で読み込み)
Controller: $headers = config("expense_headers.{$type}");
  ↓ (View に渡す)
Blade: expenses/index.blade.php
  ↓ (Component に渡す)
Component: x-expenses.table
  ↓ (各ヘッダーをループ)
各列を動的レンダリング + ExpenseFormatter で整形
```

#### 実装例（Controller）

```php
// TransportationController@index
public function index()
{
    $expenses = Expense::where('expense_type', 'transportation')
        ->with('user', 'transportationExpenses')
        ->orderBy('date', 'desc')
        ->get();

    $headers = config('expense_headers.transportation');

    return view('expenses.index', [
        'expenses' => $expenses,
        'headers'  => $headers,
        'type'     => 'transportation',
        'relation' => 'transportationExpenses',
    ]);
}
```

#### 実装例（Blade Component）

`resources/views/components/expenses/table.blade.php` で動的レンダリング：

```blade
@foreach ($headers as $header)
    @php
        $source = $header['source'] ?? 'detail';
        $raw = '-';

        if ($source === 'expense') {
            $raw = data_get($row, $header['key']);
        } elseif ($source === 'detail') {
            $raw = $detail?->{$header['key']} ?? '-';
        }

        $value = \App\Helpers\ExpenseFormatter::format($raw, $header['formatter'] ?? null);
    @endphp

    <td class="border px-3 py-2">{{ $value }}</td>
@endforeach
```

#### 一覧画面での表示内容

**全フィールドを表示** - フィルタリングなし

---

### 2. フォーム画面（create/edit）での使用

#### データフロー

```
config/expense_headers.php
  ↓ (Controller で読み込み)
BaseExpenseController->buildFormView()
  ↓ (特定フィールドを除外)
フィルタリング: id, user.name, status を除外
  ↓ (View に渡す)
Blade: expenses/form.blade.php
  ↓ (Vue Component に渡す)
Vue: ExpenseFormUnify.vue
  ↓ (各フィールドをループ)
入力フィールドを動的レンダリング
```

#### 実装例（BaseExpenseController）

```php
protected function buildFormView(
    string $configKey,
    string $title,
    string $formTitle,
    string $formAction,
    string $backUrl,
    array $details = [],
    bool $isEdit = false
) {
    // config から全フィールド取得
    $allFields = config("expense_headers.$configKey");

    // フォームに不要なフィールドを除外
    $formFields = array_values(array_filter($allFields, function ($field) {
        return !in_array($field['key'], ['id', 'user.name', 'status']);
    }));

    return view('expenses.form', [
        'details'    => $details,
        'pageTitle'  => $title,
        'formTitle'  => $formTitle,
        'formAction' => $formAction,
        'backUrl'    => $backUrl,
        'isEdit'     => $isEdit,
        'fields'     => $formFields,
    ]);
}
```

#### フォーム画面での除外フィールド

| フィールド | 除外理由 |
|-----------|---------|
| `id` | 自動採番のため入力不要 |
| `user.name` | ログインユーザーから自動取得 |
| `status` | システムが承認フローで自動制御（draft → submitted → approved/returned） |

#### フォーム画面での表示内容

**除外フィールド以外を入力可能フィールドとして表示**

---

## ExpenseFormatter の役割

### 概要

**パス**: `app/Helpers/ExpenseFormatter.php`

**役割**: データベースの生データを画面表示用に整形

### 実装

```php
namespace App\Helpers;

class ExpenseFormatter
{
  public static function format($value, ?string $type): string
  {
    return match ($type) {
      'yen' => number_format($value) . '円',
      'date' => ($value instanceof \Carbon\Carbon) ? $value->format('Y-m-d') : $value,
      'status' => expense_status_label($value),
      default => $value ?? '-',
    };
  }
}
```

### 利用可能なフォーマッタ

| フォーマッタ | 入力例 | 出力例 | 用途 |
|------------|-------|-------|------|
| `yen` | `5000` | `5,000円` | 金額表示 |
| `date` | `Carbon` or `'2025-01-15'` | `2025-01-15` | 日付表示 |
| `status` | `'draft'` | `'下書き'` | ステータス表示（日本語化） |
| （未指定） | `'example'` | `'example'` | そのまま表示 |

### expense_status_label() ヘルパー

**パス**: `app/Helpers/helpers.php`

```php
function expense_status_label(?string $status): string
{
  return [
    'draft'     => '下書き',
    'submitted' => '申請中',
    'approved'  => '承認済',
    'returned'  => '差戻し',
  ][$status] ?? '未連携';
}
```

---

## フィールド追加・削除の手順

### 新しいフィールドを追加する場合

#### 手順1: config を更新

`config/expense_headers.php` に新しいフィールド定義を追加：

```php
'transportation' => [
    // 既存のフィールド...
    ['key' => 'new_field', 'label' => '新項目', 'source' => 'detail', 'type' => 'text', 'required' => true],
],
```

#### 手順2: マイグレーション実行（必要な場合）

明細テーブルに新しいカラムを追加：

```php
Schema::table('transportation_expenses', function (Blueprint $table) {
    $table->string('new_field')->nullable();
});
```

#### 手順3: バリデーション追加（必要な場合）

各 Controller の `rules()` に追加：

```php
protected function rules(): array
{
    return [
        'details.*.new_field' => 'required|string|max:255',
        // ...
    ];
}
```

#### 完了

- 一覧画面に新しい列が自動表示される
- フォーム画面に新しい入力欄が自動表示される
- フォーマッタが必要な場合のみ `ExpenseFormatter` を拡張

### フィールドを削除する場合

#### 手順1: config から削除

`config/expense_headers.php` から該当フィールドを削除

#### 完了

- 一覧画面・フォーム画面から自動的に消える
- マイグレーションで物理削除するかは要件次第

---

## 一覧画面とフォーム画面の使い分け一覧

| フィールド | 一覧画面 | フォーム画面 | 備考 |
|-----------|---------|------------|------|
| `id` | ✅ 表示 | ❌ 非表示 | 自動採番 |
| `user.name` | ✅ 表示 | ❌ 非表示 | ログインユーザーから自動取得 |
| `status` | ✅ 表示 | ❌ 非表示 | システムが承認フローで制御 |
| `use_date` など明細項目 | ✅ 表示 | ✅ 入力可 | - |
| `amount` | ✅ 表示（円表示） | ✅ 入力可 | フォーマッタで整形 |

---

## 補足：共通 Blade ファイル

### expenses/index.blade.php

全経費種別の一覧画面で共通使用。`$type` パラメータで切り替え。

### expenses/form.blade.php

全経費種別の新規作成・編集画面で共通使用。`$isEdit` フラグで新規/編集を切り替え。

---

## まとめ

1. **config/expense_headers.php が全フィールド定義の単一情報源**
2. **一覧画面では全フィールドを表示**
3. **フォーム画面では id, user.name, status を除外して表示**
4. **ExpenseFormatter で表示整形を統一管理**
5. **新しいフィールド追加は config 更新のみで UI に反映**

この設計により、保守性・拡張性・可読性の高い経費精算システムを実現しています。

---
