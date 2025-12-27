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

※ すべての経費種別で **共通の Blade ファイル** (`expenses/index.blade.php`) を使用し、`$type` パラメータで表示内容を切り替えています。

| 画面名                 | md ファイル               | Blade ファイルパス                         | ルートパス                 | route 名               | HTTP メソッド | Controller                       |
| ---------------------- | ------------------------- | ------------------------------------------ | -------------------------- | ---------------------- | ------------- | -------------------------------- |
| 交通費一覧画面         | `transportation_index.md` | `resources/views/expenses/index.blade.php` | `/expenses/transportation` | `transportation.index` | GET           | `TransportationController@index` |
| 出張旅費一覧画面       | `business_trip_index.md`  | `resources/views/expenses/index.blade.php` | `/expenses/business_trip`  | `business_trip.index`  | GET           | `BusinessTripController@index`   |
| 接待交際費一覧画面     | `entertainment_index.md`  | `resources/views/expenses/index.blade.php` | `/expenses/entertainment`  | `entertainment.index`  | GET           | `EntertainmentController@index`  |
| 備品・消耗品費一覧画面 | `supplies_index.md`       | `resources/views/expenses/index.blade.php` | `/expenses/supply`         | `supplies.index`       | GET           | `SupplyController@index`         |
| 全体一覧画面           | `all_expenses_index.md`   | `resources/views/expenses/all.blade.php`   | `/expenses/all`            | `expenses.all`         | GET           | `AllExpensesController@index`    |

---

## 新規作成画面

※ すべての経費種別で **共通の Blade ファイル** (`expenses/form.blade.php`) を使用し、`$type` パラメータでフィールド定義を切り替えています。
※ 編集画面も同じ `form.blade.php` を使用し、`$isEdit` フラグで新規/編集を切り替えます。

| 画面名                   | md ファイル                | Blade ファイルパス                      | ルートパス                       | route 名               | HTTP メソッド | Controller                         |
| ------------------------ | -------------------------- | --------------------------------------- | -------------------------------- | ---------------------- | ------------- | ---------------------------------- |
| 交通費新規作成フォーム   | `create_expense_shared.md` | `resources/views/expenses/form.blade.php` | `/expenses/transportation/create` | `transportation.create` | GET           | `TransportationController@create`  |
| 交通費登録処理           | —                          | —                                       | `/expenses/transportation`       | `transportation.store` | POST          | `TransportationController@store`   |
| 出張旅費新規作成フォーム | `create_expense_shared.md` | `resources/views/expenses/form.blade.php` | `/expenses/business_trip/create` | `business_trip.create` | GET           | `BusinessTripController@create`    |
| 出張旅費登録処理         | —                          | —                                       | `/expenses/business_trip`        | `business_trip.store`  | POST          | `BusinessTripController@store`     |
| 接待費新規作成フォーム   | `create_expense_shared.md` | `resources/views/expenses/form.blade.php` | `/expenses/entertainment/create` | `entertainment.create` | GET           | `EntertainmentController@create`   |
| 接待費登録処理           | —                          | —                                       | `/expenses/entertainment`        | `entertainment.store`  | POST          | `EntertainmentController@store`    |
| 備品新規作成フォーム     | `create_expense_shared.md` | `resources/views/expenses/form.blade.php` | `/expenses/supply/create`        | `supplies.create`      | GET           | `SupplyController@create`          |
| 備品登録処理             | —                          | —                                       | `/expenses/supply`               | `supplies.store`       | POST          | `SupplyController@store`           |

---

## 編集画面

※ 新規作成と **同じ** `expenses/form.blade.php` を使用し、`$isEdit=true` で編集モードに切り替えます。

| 画面名               | md ファイル              | Blade ファイルパス                        | ルートパス                            | route 名                | HTTP メソッド | Controller                      |
| -------------------- | ------------------------ | ----------------------------------------- | ------------------------------------- | ----------------------- | ------------- | ------------------------------- |
| 交通費編集フォーム   | `edit_expense_shared.md` | `resources/views/expenses/form.blade.php` | `/expenses/transportation/{id}/edit`  | `transportation.edit`   | GET           | `TransportationController@edit` |
| 交通費更新処理       | —                        | —                                         | `/expenses/transportation/{id}`       | `transportation.update` | PUT/PATCH     | `TransportationController@update` |
| 出張旅費編集フォーム | `edit_expense_shared.md` | `resources/views/expenses/form.blade.php` | `/expenses/business_trip/{id}/edit`   | `business_trip.edit`    | GET           | `BusinessTripController@edit`   |
| 出張旅費更新処理     | —                        | —                                         | `/expenses/business_trip/{id}`        | `business_trip.update`  | PUT/PATCH     | `BusinessTripController@update` |
| 接待費編集フォーム   | `edit_expense_shared.md` | `resources/views/expenses/form.blade.php` | `/expenses/entertainment/{id}/edit`   | `entertainment.edit`    | GET           | `EntertainmentController@edit`  |
| 接待費更新処理       | —                        | —                                         | `/expenses/entertainment/{id}`        | `entertainment.update`  | PUT/PATCH     | `EntertainmentController@update` |
| 備品編集フォーム     | `edit_expense_shared.md` | `resources/views/expenses/form.blade.php` | `/expenses/supply/{id}/edit`          | `supplies.edit`         | GET           | `SupplyController@edit`         |
| 備品更新処理         | —                        | —                                         | `/expenses/supply/{id}`               | `supplies.update`       | PUT/PATCH     | `SupplyController@update`       |

---

## 申請処理（draft → submitted）

※ 各経費種別で共通の `ExpenseSubmitController` を使用します。

| 処理名               | md ファイル         | Blade ファイルパス | ルートパス                                | route 名               | HTTP メソッド | Controller                       |
| -------------------- | ------------------- | ------------------ | ----------------------------------------- | ---------------------- | ------------- | -------------------------------- |
| 交通費申請処理       | `approval_logic.md` | —                  | `/expenses/transportation/{expense}/submit` | `transportation.submit` | POST          | `ExpenseSubmitController@submit` |
| 出張旅費申請処理     | `approval_logic.md` | —                  | `/expenses/business_trip/{expense}/submit` | `business_trip.submit` | POST          | `ExpenseSubmitController@submit` |
| 接待費申請処理       | `approval_logic.md` | —                  | `/expenses/entertainment/{expense}/submit` | `entertainment.submit` | POST          | `ExpenseSubmitController@submit` |
| 備品申請処理         | `approval_logic.md` | —                  | `/expenses/supply/{expense}/submit`        | `supplies.submit`      | POST          | `ExpenseSubmitController@submit` |
| 共通申請処理（予備） | `approval_logic.md` | —                  | `/approvals/expenses/{expense}/submit`     | `expenses.submit`      | POST          | `ExpenseSubmitController@submit` |

---

## 承認機能（submitted → approved / returned）

※ 承認者（is_admin=true）のみが実行可能

| 処理名         | md ファイル         | Blade ファイルパス                          | ルートパス                  | route 名          | HTTP メソッド | Controller                        |
| -------------- | ------------------- | ------------------------------------------- | --------------------------- | ----------------- | ------------- | --------------------------------- |
| 承認待ち一覧   | `approval_logic.md` | `resources/views/approvals/index.blade.php` | `/approvals`                | `approvals.index` | GET           | `ExpenseApprovalController@index` |
| 承認処理       | `approval_logic.md` | —                                           | `/approvals/{id}/approve`   | `approvals.approve` | POST          | `ExpenseApprovalController@approve` |
| 差戻し処理     | `approval_logic.md` | —                                           | `/approvals/{id}/return`    | `approvals.return` | POST          | `ExpenseApprovalController@return` |

---

## 削除・CSV 出力

| 処理名           | md ファイル | Blade ファイルパス | ルートパス                       | route 名                | HTTP メソッド | Controller                      |
| ---------------- | ----------- | ------------------ | -------------------------------- | ----------------------- | ------------- | ------------------------------- |
| 交通費削除処理   | —           | —                  | `/expenses/transportation/{id}`  | `transportation.destroy` | DELETE        | `TransportationController@destroy` |
| 出張旅費削除処理 | —           | —                  | `/expenses/business_trip/{id}`   | `business_trip.destroy` | DELETE        | `BusinessTripController@destroy` |
| 接待費削除処理   | —           | —                  | `/expenses/entertainment/{id}`   | `entertainment.destroy` | DELETE        | `EntertainmentController@destroy` |
| 備品削除処理     | —           | —                  | `/expenses/supply/{id}`          | `supplies.destroy`      | DELETE        | `SupplyController@destroy`      |
| CSV 出力処理     | —           | —                  | `/expenses/export`               | `expenses.export`       | GET           | `AllExpensesController@export`  |

---
