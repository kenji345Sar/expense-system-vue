# 画面一覧・md ファイル対応・ルーティングマッピング表（Blade パス付き）

---

## Breeze 認証（自動生成）

| 画面名     | md ファイル | Blade ファイルパス                        | ルートパス  | HTTP メソッド | Controller            |
| ---------- | ----------- | ----------------------------------------- | ----------- | ------------- | --------------------- |
| ログイン   | ※自動生成   | `resources/views/auth/login.blade.php`    | `/login`    | GET/POST      | Breeze / Laravel 標準 |
| ユーザ登録 | ※自動生成   | `resources/views/auth/register.blade.php` | `/register` | GET/POST      | Breeze / Laravel 標準 |

---

## メニュー画面

| 画面名       | md ファイル     | Blade ファイルパス                        | ルートパス       | HTTP メソッド | Controller               |
| ------------ | --------------- | ----------------------------------------- | ---------------- | ------------- | ------------------------ |
| メニュー画面 | `menu_index.md` | `resources/views/expenses/menu.blade.php` | `/expenses/menu` | GET           | `ExpenseController@menu` |

---

## 一覧画面（カテゴリ別）

| 画面名                 | md ファイル               | Blade ファイルパス                               | ルートパス                 | HTTP メソッド | Controller                    |
| ---------------------- | ------------------------- | ------------------------------------------------ | -------------------------- | ------------- | ----------------------------- |
| 交通費一覧画面         | `transportation_index.md` | `resources/views/transportation/index.blade.php` | `/expenses/transportation` | GET           | `ExpenseController@index`     |
| 出張旅費一覧画面       | `business_trip_index.md`  | `resources/views/business_trip/index.blade.php`  | `/expenses/business_trip`  | GET           | `ExpenseController@index`     |
| 接待交際費一覧画面     | `entertainment_index.md`  | `resources/views/entertainment/index.blade.php`  | `/expenses/entertainment`  | GET           | `ExpenseController@index`     |
| 備品・消耗品費一覧画面 | `supplies_index.md`       | `resources/views/supplies/index.blade.php`       | `/expenses/supplies`       | GET           | `ExpenseController@index`     |
| 全体一覧画面           | `all_expenses_index.md`   | `resources/views/expenses/all.blade.php`         | `/expenses/all`            | GET           | `AllExpensesController@index` |

---

## 新規作成画面

| 画面名               | md ファイル                       | Blade ファイルパス                                          | ルートパス                | HTTP メソッド | Controller                             |
| -------------------- | --------------------------------- | ----------------------------------------------------------- | ------------------------- | ------------- | -------------------------------------- |
| 新規作成画面（共通） | `create_expense_shared.md`        | `resources/views/expenses/create.blade.php`                 | `/expenses/{type}/create` | GET           | `ExpenseController@create`             |
| 登録処理             | —                                 | —                                                           | `/expenses/{type}`        | POST          | `ExpenseController@store`              |
| 出張旅費補助         | `create_expense_business_trip.md` | `resources/views/business_trip/create_additional.blade.php` | ※補助用途                 | GET           | `BusinessTripExpenseController@create` |

---

## 編集画面（共通）

| 画面名           | md ファイル              | Blade ファイルパス                        | ルートパス                   | HTTP メソッド | Controller                 |
| ---------------- | ------------------------ | ----------------------------------------- | ---------------------------- | ------------- | -------------------------- |
| 編集画面（共通） | `edit_expense_shared.md` | `resources/views/expenses/edit.blade.php` | `/expenses/{type}/{id}/edit` | GET           | `ExpenseController@edit`   |
| 更新処理         | —                        | —                                         | `/expenses/{type}/{id}`      | PUT           | `ExpenseController@update` |

---

## 申請処理・削除・CSV 出力

| 処理名       | md ファイル         | Blade ファイルパス | ルートパス                     | HTTP メソッド | Controller                    |
| ------------ | ------------------- | ------------------ | ------------------------------ | ------------- | ----------------------------- |
| 申請処理     | `approval_logic.md` | —                  | `/expenses/{type}/{id}/submit` | POST          | `ExpenseController@submit`    |
| 削除処理     | —                   | —                  | `/expenses/{type}/{id}`        | DELETE        | `ExpenseController@destroy`   |
| CSV 出力処理 | —                   | —                  | `/expenses/{type}/export`      | GET           | `ExpenseController@exportCsv` |

---
