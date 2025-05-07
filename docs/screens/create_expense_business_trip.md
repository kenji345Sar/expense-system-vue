# 画面仕様書：出張旅費新規作成画面（共通構成）

---

## 基本情報

- **画面名**：出張旅費新規作成画面（共通構成）
- **URL**：`/expenses/business_trip/create`
- **HTTPメソッド**：GET（表示） / POST（登録）
- **Controller**：
  - 表示：`BusinessTripExpenseController@create`
  - 登録：`BusinessTripExpenseController@store`
- **Bladeテンプレート**：`resources/views/expenses/create.blade.php`（共通）
- **渡すデータ**：
  - ログインユーザー情報
  - 初期状態の明細行（1行）
  - expense_type: `business_trip`

---

## 使用テーブル

| テーブル名                | 用途                                           |
|---------------------------|------------------------------------------------|
| `expenses`                | 経費共通情報（申請者、日付、ステータス等）     |
| `business_trip_expenses`  | 明細（出発地・出張日・目的地・目的・交通手段等） |
| `users`                   | ログインユーザー識別用                         |

---

## 表示項目（カテゴリ固有）

| 項目             | 説明                                     |
|------------------|------------------------------------------|
| 出張日           | 日付入力欄（明細ごと）                     |
| 出発地           | テキスト入力                              |
| 目的地           | テキスト入力                              |
| 出張目的         | テキスト入力                              |
| 交通手段         | テキスト入力（例：新幹線、飛行機など）      |
| 宿泊有無         | チェックボックスまたはラジオボタン（有／無） |
| 金額             | 数値入力                                  |
| 備考             | テキストエリア（任意）                    |
| 明細追加・削除   | JavaScript による動的行操作               |
| 添付ファイル欄   | 複数ファイル対応                           |
| 登録／戻るボタン | 登録：POST／戻る：一覧へリンク              |

---

## バリデーションルール（カテゴリ別）

```php
[
  'expenses.*.business_trip_date' => 'required|date',
  'expenses.*.departure'          => 'required|string',
  'expenses.*.destination'        => 'required|string',
  'expenses.*.purpose'            => 'required|string',
  'expenses.*.transportation'     => 'nullable|string',
  'expenses.*.accommodation'      => 'nullable|boolean',
  'expenses.*.amount'             => 'required|numeric|min:1',
  'expenses.*.remarks'            => 'nullable|string',
  'attachments.*'                 => 'nullable|file|max:5120|mimes:pdf,jpeg,png,xlsx,xls',
]
```

---

## 明細の扱い

- 初期は1行表示、追加可能
- 複数行は配列で送信され、`expenses` に1件＋明細複数が保存される
- `expense_type = business_trip` として識別

---

## 認証・権限

| ロール         | アクセス可否 | 備考                          |
|----------------|--------------|-------------------------------|
| 一般ユーザー     | ○            | 自身の出張旅費を登録可能         |
| 承認者           | ○            | 自らの出張分として利用可能       |
| 管理者（is_admin） | ○            | 必要に応じて代理作成なども可想定 |

---

## ステータス制御

- 登録直後は常に `draft`
- 申請は一覧画面から行う

---

## 実装準備完了チェック

- ☑ コントローラ／Blade／ルーティングが明確
- ☑ 明細構成とテーブルマッピングが明確
- ☑ カテゴリ固有のバリデーションが定義済
- ☑ 共通テンプレートを活用した構成である

---
