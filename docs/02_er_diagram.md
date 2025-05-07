
## 📘 データベース設計書（ER図）

---

### `users` テーブル

| カラム名           | 型               | Null | Key | Default | Extra           |
|--------------------|------------------|------|-----|---------|-----------------|
| id                 | bigint unsigned  | NO   | PRI | NULL    | auto_increment  |
| name               | varchar(255)     | NO   |     | NULL    |                 |
| email              | varchar(255)     | NO   | UNI | NULL    |                 |
| is_admin           | tinyint(1)       | NO   |     | 0       |                 |
| email_verified_at  | timestamp        | YES  |     | NULL    |                 |
| password           | varchar(255)     | NO   |     | NULL    |                 |
| remember_token     | varchar(100)     | YES  |     | NULL    |                 |
| created_at         | timestamp        | YES  |     | NULL    |                 |
| updated_at         | timestamp        | YES  |     | NULL    |                 |

---

### `supplies_expenses`（備品・消耗品費）

| カラム名    | 型               | Null | Key | Default | Extra           |
|-------------|------------------|------|-----|---------|-----------------|
| id          | bigint unsigned  | NO   | PRI | NULL    | auto_increment  |
| date        | date             | NO   |     | NULL    |                 |
| item_name   | varchar(255)     | NO   |     | NULL    |                 |
| quantity    | int              | NO   |     | NULL    |                 |
| unit_price  | int              | NO   |     | NULL    |                 |
| total_price | int              | NO   |     | NULL    |                 |
| user_id     | bigint unsigned  | NO   |     | NULL    |                 |
| remarks     | text             | YES  |     | NULL    |                 |
| created_at  | timestamp        | YES  |     | NULL    |                 |
| updated_at  | timestamp        | YES  |     | NULL    |                 |

---

### `transportation_expenses`（交通費）

| カラム名      | 型               | Null | Key | Default | Extra           |
|---------------|------------------|------|-----|---------|-----------------|
| id            | bigint unsigned  | NO   | PRI | NULL    | auto_increment  |
| use_date      | date             | NO   |     | NULL    |                 |
| departure     | varchar(255)     | NO   |     | NULL    |                 |
| arrival       | varchar(255)     | NO   |     | NULL    |                 |
| route         | varchar(255)     | YES  |     | NULL    |                 |
| amount        | decimal(10,2)    | NO   |     | NULL    |                 |
| user_id       | bigint unsigned  | NO   |     | NULL    |                 |
| expense_id    | bigint unsigned  | YES  | MUL | NULL    |                 |
| display_order | int              | YES  |     | NULL    |                 |
| remarks       | text             | YES  |     | NULL    |                 |
| created_at    | timestamp        | YES  |     | NULL    |                 |
| updated_at    | timestamp        | YES  |     | NULL    |                 |

---

### `entertainment_expenses`（接待交際費）

| カラム名            | 型               | Null | Key | Default | Extra           |
|---------------------|------------------|------|-----|---------|-----------------|
| id                  | bigint unsigned  | NO   | PRI | NULL    | auto_increment  |
| entertainment_date  | date             | NO   |     | NULL    |                 |
| client_name         | varchar(255)     | NO   |     | NULL    |                 |
| place               | varchar(255)     | NO   |     | NULL    |                 |
| amount              | int              | NO   |     | NULL    |                 |
| user_id             | bigint unsigned  | NO   |     | NULL    |                 |
| content             | text             | YES  |     | NULL    |                 |
| created_at          | timestamp        | YES  |     | NULL    |                 |
| updated_at          | timestamp        | YES  |     | NULL    |                 |

---

### `business_trip_expenses`（出張旅費）

| カラム名            | 型               | Null | Key | Default | Extra           |
|---------------------|------------------|------|-----|---------|-----------------|
| id                  | bigint unsigned  | NO   | PRI | NULL    | auto_increment  |
| departure           | varchar(255)     | NO   |     | NULL    |                 |
| business_trip_date  | date             | NO   |     | NULL    |                 |
| destination         | varchar(255)     | NO   |     | NULL    |                 |
| purpose             | varchar(255)     | NO   |     | NULL    |                 |
| transportation      | varchar(255)     | YES  |     | NULL    |                 |
| accommodation       | tinyint(1)       | YES  |     | NULL    |                 |
| amount              | int              | NO   |     | NULL    |                 |
| remarks             | text             | YES  |     | NULL    |                 |
| created_at          | timestamp        | YES  |     | NULL    |                 |
| updated_at          | timestamp        | YES  |     | NULL    |                 |

---

### `expenses`（経費共通）

| カラム名                    | 型               | Null | Key | Default | Extra           |
|-----------------------------|------------------|------|-----|---------|-----------------|
| id                          | bigint unsigned  | NO   | PRI | NULL    | auto_increment  |
| user_id                     | bigint unsigned  | NO   | MUL | NULL    |                 |
| date                        | date             | NO   |     | NULL    |                 |
| amount                      | decimal(10,2)    | YES  |     | NULL    |                 |
| description                 | varchar(255)     | YES  |     | NULL    |                 |
| expense_type                | varchar(255)     | NO   |     | NULL    |                 |
| created_at                  | timestamp        | YES  |     | NULL    |                 |
| updated_at                  | timestamp        | YES  |     | NULL    |                 |
| status                      | varchar(255)     | NO   |     | draft   |                 |
| approver_id                 | bigint unsigned  | YES  |     | NULL    |                 |
| approved_at                 | timestamp        | YES  |     | NULL    |                 |
| approval_comment            | text             | YES  |     | NULL    |                 |
| transportation_expense_id  | bigint unsigned  | YES  | MUL | NULL    |                 |

---

### `jobs`（キューされたジョブ）

| カラム名     | 型               | 備考                           |
|--------------|------------------|--------------------------------|
| id           | BIGINT           | PK                             |
| queue        | STRING           | キュー名（インデックス付き）   |
| payload      | LONGTEXT         | シリアライズされたジョブ内容   |
| attempts     | TINYINT UNSIGNED | 試行回数                       |
| reserved_at  | INTEGER UNSIGNED | 予約タイムスタンプ（nullable） |
| available_at | INTEGER UNSIGNED | 実行可能タイムスタンプ         |
| created_at   | INTEGER UNSIGNED | 作成時刻タイムスタンプ         |

---

### `cache`（キャッシュストレージ）

| カラム名   | 型      | 備考                             |
|------------|---------|----------------------------------|
| key        | STRING  | プライマリキー（キャッシュキー） |
| value      | TEXT    | キャッシュされた値               |
| expiration | INTEGER | 有効期限（UNIX タイムスタンプ）  |
