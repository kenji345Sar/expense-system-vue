# 画面仕様書：経費編集画面（共通フォーム構成）

---

## 基本情報

- **画面名**：経費編集画面（共通構成）
- **URL**：`/expenses/{type}/{id}/edit`
- **HTTPメソッド**：GET（表示） / PUT or PATCH（更新）
- **Controller**：
  - 表示：`{Type}Controller@edit`（例：`TransportationController@edit`）
  - 更新：`{Type}Controller@update`
- **Bladeテンプレート**：`resources/views/expenses/form.blade.php`（共通・新規作成画面と同じ）
- **渡すデータ**：
  - 対象となる expense データ
  - 対応する明細行データ（複数）
  - expense_type: 呼び出し元に応じたカテゴリ指定
  - fields: `config/expense_headers.php` から生成されたフォーム用フィールド定義
  - isEdit: `true`（編集モードフラグ）

> **参考**: フィールド定義の仕組みについては [`config_driven_ui.md`](./config_driven_ui.md) を参照してください。

---

## 使用テーブル

| テーブル名               | 用途                                     |
|--------------------------|------------------------------------------|
| `expenses`               | 経費共通情報（申請者、日付、金額合計、ステータス等） |
| `<type>_expenses`        | 明細情報（カテゴリに応じた個別構造）     |
| `users`                  | ログインユーザー情報（編集可否チェック） |

---

## 表示項目（共通画面）

- `expenses/form.blade.php`（新規作成と同じ）に準拠し、以下を編集可能：
  - 明細の追加・削除・修正
  - 備考・金額・経路など各項目
  - 添付ファイルの再アップロードまたは削除（任意）

### フィールド自動生成の仕組み

- 新規作成画面と同じく、`config/expense_headers.php` から自動生成されます
- `BaseExpenseController->buildFormView()` が以下のフィールドを除外：
  - `id`（自動採番）
  - `user.name`（ログインユーザーから自動取得）
  - `status`（システムが承認フローで自動制御）
- 編集時は `$isEdit = true` フラグで新規作成と区別
- 詳細は [`config_driven_ui.md`](./config_driven_ui.md) を参照

---

## バリデーションルール（create と同様）

- 明細に対して再バリデーション
- 編集中のステータスが `draft` のときのみ許可
- `submitted` / `approved` / `returned` の編集は禁止（Controller or Policy で制御）

> **注意**: ステータスフィールドはフォームに表示されないため、ユーザーが直接ステータスを変更することはできません。ステータスは承認フロー（申請・承認・差戻し）によってのみ変更されます。

---

## ステータス制御

- `draft`：編集可
- `submitted` or `approved`：編集不可（一覧画面に戻すなど）

---

## 実装準備完了チェック（この画面）

- ☑ URL・Controller・Blade（共通）の構成が定義されている
- ☑ 編集対象データの取得方法が明確
- ☑ 明細更新・削除・追加ロジックが整理されている
- ☑ 編集可否はステータスとログインユーザーにより判定される

---
