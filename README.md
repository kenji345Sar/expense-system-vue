# expense-system（経費精算システム）

このプロジェクトは Laravel を使った経費精算管理システムです。  
備品・交通費・接待交際費などの申請を登録・編集・一覧・削除できる機能を持ちます。

---

## 構成技術

-   Laravel 10.x
-   MySQL 8.x
-   Redis

※ Laravel Sail は使用しておらず、`docker-compose` による構成で動作しています。

---

## 必要な環境

-   Docker / Docker Compose
-   Git
-   ブラウザ（Chrome 等）

---

## セットアップ手順

### 1. リポジトリをクローン

```bash
git clone https://github.com/kenji345Sar/expense-system.git
cd expense-system
```

### 2. `.env` 作成と依存パッケージのインストール

```bash
cp .env.example .env
docker-compose up -d --build
docker-compose exec laravel.test composer install
docker-compose exec laravel.test php artisan key:generate
```

### 3. MySQL データベース初期化（Mac → Windows 対応）

#### Mac 側で作成した `dump.sql` を使用

```bash
# dump.sql をコンテナにコピー
docker cp dump.sql expense-system-mysql-1:/dump.sql

# コンテナに入る
docker exec -it expense-system-mysql-1 bash

# インポート実行
mysql -u root -p laravel < /dump.sql
```

※パスワードは `.env` に記載されている値を使用してください。

---

## 認証機能について

Laravel Breeze（Blade 版）を使用して認証機能を導入しています。

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run build
php artisan migrate
```

ログイン後、各種申請機能（備品・消耗品費など）を利用できます。

---

## 備考

-   `storage/` や `vendor/` ディレクトリは `.gitignore` により Git 管理外です。
-   `meilisearch` や `mailpit` などのサービスは使用していません（docker-compose.yml 上でも除外済み）。
