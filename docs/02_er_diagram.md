# データベース設計書（ER図）

## users テーブル
| カラム名   | 型       | 備考              |
|------------|----------|-------------------|
| id         | BIGINT   | PK                |
| name       | STRING   |                   |
| email      | STRING   | ユニーク           |
| password   | STRING   | ハッシュ化される  |
| is_admin   | BOOLEAN  | 管理者フラグ      |

## supplies_expenses（備品・消耗品費）
| カラム名   | 型       | 備考              |
|------------|----------|-------------------|
| id         | BIGINT   | PK                |
| user_id    | BIGINT   | FK（users）       |
| item_name  | STRING   |                   |
| quantity   | INTEGER  |                   |
| unit_price | INTEGER  |                   |
| total_price| INTEGER  | 計算結果          |
| note       | TEXT     | 備考              |
| date       | DATE     | 購入日など        |

※ 他のモジュールも同様の構成です。
