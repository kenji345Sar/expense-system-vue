# ファイル添付仕様（共通）

---

## 概要

このドキュメントは経費精算システムにおける「ファイル添付」機能の共通仕様を示す。交通費、出張旅費、備品、接待などカテゴリを問わず共通に扱う。

---

## 機能概要

| 項目       | 内容                                                         |
|------------|--------------------------------------------------------------|
| 対象画面   | 新規作成画面、編集画面（共通）                               |
| 添付方法   | フォーム上の `<input type="file" name="attachments[]">` を利用 |
| 添付数     | 複数ファイル可（`multiple` 属性あり）                         |
| ファイル形式 | PDF, JPEG, PNG, Excel など任意（バリデーションで制御）        |
| 保存場所   | `storage/app/attachments/{expense_id}/` に保存                |
| DB格納     | 添付ファイルのパス・元名・MIMEタイプ等を別テーブルに記録       |

---

## 使用テーブル案（例：`attachments`）

| カラム名         | 型               | 備考                        |
|------------------|------------------|-----------------------------|
| id               | bigint unsigned  | 主キー                      |
| expense_id       | bigint unsigned  | `expenses.id` に外部キー     |
| original_name    | varchar(255)     | 元のファイル名              |
| stored_name      | varchar(255)     | 保存ファイル名              |
| mime_type        | varchar(100)     | MIMEタイプ                  |
| size             | int              | ファイルサイズ（バイト）     |
| created_at       | timestamp        | 登録日時                    |

---

## バリデーション例（Laravel）

```php
'attachments.*' => 'nullable|file|max:5120|mimes:pdf,jpeg,png,xlsx,xls',
```

---

## 備考

- 承認処理とは分離されており、あくまで「申請内容の補足資料」として扱う
- 削除・再添付は編集画面にて対応予定
- Laravel の `Storage` ファサード経由でアップロード処理を統一管理

---
