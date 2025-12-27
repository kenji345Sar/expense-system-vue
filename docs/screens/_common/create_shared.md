# 画面仕様書：経費新規作成画面（共通フォーム構成）

---

## 基本情報

-   **画面名**：経費新規作成画面（共通構成）
-   **URL**：`/expenses/{type}/create`（例：`transportation`, `business_trip`, etc.）
-   **HTTP メソッド**：GET（表示） / POST（登録）
-   **Controller**：
    -   表示：`{Type}Controller@create`（例：`TransportationController@create`）
    -   登録：`{Type}Controller@store`
-   **Blade テンプレート**：`resources/views/expenses/form.blade.php`（共通・編集画面と同じ）
-   **渡すデータ**：
    -   ログインユーザー情報（`auth()`）
    -   初期状態の明細行（1 行）
    -   expense_type: 呼び出し元に応じたカテゴリ指定
    -   fields: `config/expense_headers.php` から生成されたフォーム用フィールド定義

> **参考**: フィールド定義の仕組みについては [`config_driven_ui.md`](./config_driven_ui.md) を参照してください。

---

## 使用テーブル

| テーブル名        | 用途                                                 |
| ----------------- | ---------------------------------------------------- |
| `expenses`        | 経費共通情報（申請者、日付、金額合計、ステータス等） |
| `<type>_expenses` | 明細情報（カテゴリに応じた個別構造）                 |
| `users`           | ログインユーザー情報の取得（`user_id` に使用）       |

---

## 表示項目（カテゴリ共通構成）

| 要素         | 説明                                  |
| ------------ | ------------------------------------- |
| 明細行       | 初期 1 行、追加・削除可能             |
| 添付ファイル | 複数アップロード可能（任意）          |
| 備考         | 経費全体に対する自由入力欄            |
| 登録・戻る   | 登録：POST 送信、戻る：一覧画面へ遷移 |

### フィールド自動生成の仕組み

- 表示される入力フィールドは `config/expense_headers.php` から自動生成されます
- `BaseExpenseController->buildFormView()` が以下のフィールドを除外してフォーム用フィールドを構築：
  - `id`（自動採番）
  - `user.name`（ログインユーザーから自動取得）
  - `status`（システムが承認フローで自動制御）
- 詳細は [`config_driven_ui.md`](./config_driven_ui.md) を参照

---

## カテゴリ別明細入力項目

### 交通費（transportation）

| 項目   | 説明                 |
| ------ | -------------------- |
| 利用日 | 日付入力             |
| 出発地 | テキスト入力         |
| 到着地 | テキスト入力         |
| 経路   | テキスト入力（任意） |
| 金額   | 数値入力             |

---

### 出張旅費（business_trip）

| 項目     | 説明                             |
| -------- | -------------------------------- |
| 出張日   | 日付入力                         |
| 出発地   | テキスト入力                     |
| 目的地   | テキスト入力                     |
| 出張目的 | テキスト入力                     |
| 交通手段 | テキスト入力（任意）             |
| 宿泊有無 | チェックボックスまたはラジオ選択 |
| 金額     | 数値入力                         |

---

### 接待交際費（entertainment）

| 項目     | 説明                 |
| -------- | -------------------- |
| 日付     | 接待実施日（date）   |
| 接待相手 | 会社・担当者名など   |
| 場所     | 店舗・会場名など     |
| 金額     | 支出額               |
| 内容     | 接待目的や内容の説明 |

---

### 備品・消耗品費（supplies）

| 項目   | 説明                        |
| ------ | --------------------------- |
| 購入日 | 購入日（日付）              |
| 品名   | 備品・消耗品の名称          |
| 数量   | 購入数（整数）              |
| 単価   | 単価（整数）                |
| 金額   | 数量 × 単価を自動計算でも可 |

---

## バリデーションルール（カテゴリ別）

### 交通費（transportation）

```php
[
  'expenses.*.use_date'   => 'required|date',
  'expenses.*.departure'  => 'required|string',
  'expenses.*.arrival'    => 'required|string',
  'expenses.*.route'      => 'nullable|string',
  'expenses.*.amount'     => 'required|numeric|min:1',
]
```

### 出張旅費（business_trip）

```php
[
  'expenses.*.business_trip_date' => 'required|date',
  'expenses.*.departure'          => 'required|string',
  'expenses.*.destination'        => 'required|string',
  'expenses.*.purpose'            => 'required|string',
  'expenses.*.transportation'     => 'nullable|string',
  'expenses.*.accommodation'      => 'nullable|boolean',
  'expenses.*.amount'             => 'required|numeric|min:1',
]
```

### 接待交際費（entertainment）

```php
[
  'expenses.*.entertainment_date' => 'required|date',
  'expenses.*.client_name'        => 'required|string',
  'expenses.*.place'              => 'required|string',
  'expenses.*.amount'             => 'required|numeric|min:1',
  'expenses.*.content'            => 'nullable|string',
]
```

### 備品・消耗品費（supplies）

```php
[
  'expenses.*.date'        => 'required|date',
  'expenses.*.item_name'   => 'required|string',
  'expenses.*.quantity'    => 'required|integer|min:1',
  'expenses.*.unit_price'  => 'required|integer|min:1',
  'expenses.*.total_price' => 'required|integer|min:1',
]
```

### 添付ファイル（共通）

```php
[
  'attachments.*' => 'nullable|file|max:5120|mimes:pdf,jpeg,png,xlsx,xls',
]
```

---

## 明細の扱い

-   初期表示時は 1 行、追加ボタンで複数行入力可
-   全明細は `expenses` の `id` と 1:N 関係で登録される

---

## 認証・権限

この画面はログイン必須です（`auth` ミドルウェア適用）

| ロール             | アクセス可否 | 備考                           |
| ------------------ | ------------ | ------------------------------ |
| 一般ユーザー       | ○            | 自身の申請用として使用         |
| 承認者             | ○            | 自らの申請として使用可能       |
| 管理者（is_admin） | ○            | 必要に応じて代理作成なども可能 |

---

## ステータス制御

-   新規作成直後は常に `draft`
-   申請は一覧画面から行う（create 画面からは行わない）

---

## 実装準備完了チェック（この画面）

-   ☑ URL・Controller・Blade（共通）の構成が定義されている
-   ☑ 各カテゴリの表示項目が網羅されている
-   ☑ 明細構造・バリデーションもカテゴリに応じて想定済み
-   ☑ ステータス・ファイル添付・戻る動線が整理されている

---
