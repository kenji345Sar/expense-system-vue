# 画面一覧・mdファイル対応・ルーティングマッピング表

---

## Breeze認証（自動生成）

| 画面名       | mdファイル         | ルートパス            | HTTPメソッド | Controller               |
|--------------|--------------------|------------------------|--------------|--------------------------|
| ログイン     | ※自動生成         | `/login`               | GET/POST     | Breeze / Laravel標準     |
| ユーザ登録   | ※自動生成         | `/register`            | GET/POST     | Breeze / Laravel標準     |

---

## メニュー画面

| 画面名       | mdファイル             | ルートパス              | HTTPメソッド | Controller                 |
|--------------|------------------------|--------------------------|--------------|----------------------------|
| メニュー画面 | `menu_index.md`        | `/expenses/menu`         | GET          | `ExpenseController@menu`   |

---

## 一覧画面（カテゴリ別）

| 画面名               | mdファイル                   | ルートパス                | HTTPメソッド | Controller                 |
|----------------------|------------------------------|----------------------------|--------------|----------------------------|
| 交通費一覧画面       | `transportation_index.md`     | `/expenses/transportation` | GET          | `ExpenseController@index`  |
| 出張旅費一覧画面     | `business_trip_index.md`      | `/expenses/business_trip`  | GET          | `ExpenseController@index`  |
| 接待交際費一覧画面   | `entertainment_index.md`      | `/expenses/entertainment`  | GET          | `ExpenseController@index`  |
| 備品・消耗品費一覧画面 | `supplies_index.md`           | `/expenses/supplies`       | GET          | `ExpenseController@index`  |
| 全体一覧画面         | `all_expenses_index.md`       | `/expenses/all`            | GET          | `AllExpensesController@index` |

---

## 新規作成画面

| 画面名         | mdファイル                     | ルートパス                      | HTTPメソッド | Controller                  |
|----------------|--------------------------------|----------------------------------|--------------|-----------------------------|
| 新規作成画面（共通） | `create_expense_shared.md`       | `/expenses/{type}/create`        | GET          | `ExpenseController@create`  |
| 登録処理       | —                              | `/expenses/{type}`              | POST         | `ExpenseController@store`   |
| 出張旅費補助   | `create_expense_business_trip.md` | ※補助用途                       | GET          | `BusinessTripExpenseController@create` |

---

## 編集画面（共通）

| 画面名         | mdファイル             | ルートパス                            | HTTPメソッド | Controller                  |
|----------------|------------------------|----------------------------------------|--------------|-----------------------------|
| 編集画面（共通） | `edit_expense_shared.md` | `/expenses/{type}/{id}/edit`            | GET          | `ExpenseController@edit`    |
| 更新処理       | —                      | `/expenses/{type}/{id}`                | PUT          | `ExpenseController@update`  |

---

## 申請処理・削除・CSV出力

| 処理名       | mdファイル                 | ルートパス                              | HTTPメソッド | Controller                  |
|--------------|----------------------------|------------------------------------------|--------------|-----------------------------|
| 申請処理     | `approval_logic.md`        | `/expenses/{type}/{id}/submit`           | POST         | `ExpenseController@submit`  |
| 削除処理     | —                          | `/expenses/{type}/{id}`                  | DELETE       | `ExpenseController@destroy` |
| CSV出力処理  | —                          | `/expenses/{type}/export`                | GET          | `ExpenseController@exportCsv` |

---

