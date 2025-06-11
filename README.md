# 経費精算システム（expense-system）

本システムは **Vue.js + Laravel + MySQL + Docker** を用いた経費精算システムです。

下記リポジトリにて、モジュールごとの一覧画面やフォームの共通化により、再利用性の高い構成を目指して開発を進めています。

👉 https://github.com/kenji345Sar/expense-system

---

## 使用技術

-   Laravel
-   Vue.js
-   MySQL
-   Docker

---

## 起動方法

```bash
git clone <このリポジトリ>
cd expense-system-vue
cp .env.example .env
# 開発環境
 docker-compose -f docker/dev/docker-compose.yml up -d

## Laravelアプリケーションサーバーの起動

```bash
# Laravelアプリケーションコンテナに接続
docker exec -it dev-app-1 bash

# Laravel開発サーバーを起動（コンテナ内で実行）
php artisan serve --host=0.0.0.0 --port=8000
```


```

## 現在の開発ブランチと内容

main: feature/export-csv
- 全申請書一覧、検索、csv出力

feature/unify-controller
- BaseExpenseController を追加し、4モジュールの共通処理を継承構造に統一
- データ登録・更新処理は ExpenseService に移植
- バリデーションは各モジュールの Request クラスに分離

feature/module-add-modify-unity

-   全モジュールの新規・編集フォームを共通化
-   過去の create/edit/index ファイルは xxx\_\*.blade.php にリネームし、混乱防止のため一時保持中

feature/module-list-unify
各モジュールの一覧画面を共通化し、再利用可能なレイアウトに統一

feature/unify-form-v2
各モジュールの新規登録・編集画面の共通化対応
