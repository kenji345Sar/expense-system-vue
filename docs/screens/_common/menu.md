# 画面仕様書：メニュー画面（カテゴリ選択）

---

## 基本情報

-   **画面名**：メニュー画面（カテゴリ選択）
-   **URL**：`/expenses/menu`
-   **HTTP メソッド**：GET
-   **Controller**：`ExpenseController@menu`
-   **Blade テンプレート**：`resources/views/expenses/menu.blade.php`
-   **渡すデータ**：なし（必要に応じてログインユーザー情報など）

---

## ボタン／リンク一覧

| ボタン名           | 遷移先 URL                 | 備考         |
| ------------------ | -------------------------- | ------------ |
| 交通費一覧         | `/expenses/transportation` |              |
| 出張旅費一覧       | `/expenses/business_trip`  |              |
| 接待交際費一覧     | `/expenses/entertainment`  |              |
| 備品・消耗品費一覧 | `/expenses/supplies`       |              |
| 全体一覧           | `/expenses/all`            | 一覧集約表示 |

---

## 備考

-   Laravel Breeze によるログイン後の遷移先としてこの画面を設定予定。
    -   例：Breeze のデフォルト遷移 `/home` を `/expenses/menu` に変更。
-   認証ミドルウェア（`auth`）適用済み。
-   他モジュールへの起点画面として、ユーザー体験を意識したレイアウト設計を検討。
