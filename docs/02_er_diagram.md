# データベース設計書（ER 図）

## users テーブル

| カラム名 | 型      | 備考             |
| -------- | ------- | ---------------- |
| id       | BIGINT  | PK               |
| name     | STRING  |                  |
| email    | STRING  | ユニーク         |
| password | STRING  | ハッシュ化される |
| is_admin | BOOLEAN | 管理者フラグ     |

## supplies_expenses（備品・消耗品費）

| カラム名    | 型      | 備考        |
| ----------- | ------- | ----------- |
| id          | BIGINT  | PK          |
| user_id     | BIGINT  | FK（users） |
| item_name   | STRING  |             |
| quantity    | INTEGER |             |
| unit_price  | INTEGER |             |
| total_price | INTEGER | 計算結果    |
| note        | TEXT    | 備考        |
| date        | DATE    | 購入日など  |

## transportation_expenses（交通費）

| カラム名  | 型      | 備考        |
| --------- | ------- | ----------- |
| id        | BIGINT  | PK          |
| user_id   | BIGINT  | FK（users） |
| departure | STRING  | 出発地      |
| arrival   | STRING  | 到着地      |
| date      | DATE    | 利用日      |
| amount    | INTEGER | 金額        |
| note      | TEXT    | 備考        |

## entertainment_expenses（接待交際費）

| カラム名           | 型      | 備考        |
| ------------------ | ------- | ----------- |
| id                 | BIGINT  | PK          |
| user_id            | BIGINT  | FK（users） |
| entertainment_date | DATE    | 実施日      |
| partner            | STRING  | 接待先      |
| location           | STRING  | 場所        |
| amount             | INTEGER | 金額        |
| note               | TEXT    | 備考        |

## business_trip_expenses（出張旅費）

| カラム名    | 型      | 備考        |
| ----------- | ------- | ----------- |
| id          | BIGINT  | PK          |
| user_id     | BIGINT  | FK（users） |
| destination | STRING  | 出張先      |
| purpose     | STRING  | 目的        |
| start_date  | DATE    | 出発日      |
| end_date    | DATE    | 帰着日      |
| amount      | INTEGER | 金額        |
| note        | TEXT    | 備考        |

## expenses（経費共通）

| カラム名                  | 型       | 備考                          |
| ------------------------- | -------- | ----------------------------- |
| id                        | BIGINT   | PK                            |
| user_id                   | BIGINT   | FK（users）                   |
| expense_type              | STRING   | 種別（交通費など）            |
| amount                    | INTEGER  | 金額                          |
| status                    | STRING   | 承認ステータス                |
| submitted_at              | DATETIME | 申請日時                      |
| approved_at               | DATETIME | 承認日時                      |
| rejected_at               | DATETIME | 却下日時                      |
| note                      | TEXT     | 備考                          |
| transportation_expense_id | BIGINT   | FK（transportation_expenses） |

## jobs（キューされたジョブ）

| カラム名     | 型               | 備考                           |
| ------------ | ---------------- | ------------------------------ |
| id           | BIGINT           | PK                             |
| queue        | STRING           | キュー名（インデックス付き）   |
| payload      | LONGTEXT         | シリアライズされたジョブ内容   |
| attempts     | TINYINT UNSIGNED | 試行回数                       |
| reserved_at  | INTEGER UNSIGNED | 予約タイムスタンプ（nullable） |
| available_at | INTEGER UNSIGNED | 実行可能タイムスタンプ         |
| created_at   | INTEGER UNSIGNED | 作成時刻タイムスタンプ         |

## cache（キャッシュストレージ）

| カラム名   | 型      | 備考                             |
| ---------- | ------- | -------------------------------- |
| key        | STRING  | プライマリキー（キャッシュキー） |
| value      | TEXT    | キャッシュされた値               |
| expiration | INTEGER | 有効期限（UNIX タイムスタンプ）  |
