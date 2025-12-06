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

## セットアップ

```bash
git clone <このリポジトリ>
cd expense-system-vue3
cp .env.example .env
```

---

## 開発環境（dev1 / dev2）

このプロジェクトでは、開発用に 2 種類の環境を用意しています。

### dev1（最小構成 Laravel 環境）

- Laravel 組み込みサーバーで動かすシンプルな環境です。
- nginx / Vite / Vue は使わず、主に API や簡単な画面の確認用として利用します。
- 軽く動作確認したいときや、バックエンドだけを素早く試したいときに使用します。

**主な使い方（例）**

```bash
# コンテナ起動
docker-compose -f docker/dev/docker-compose.yml up -d

# Laravelアプリケーションコンテナに接続
docker exec -it dev-app-1 bash

# Laravel開発サーバーを起動（コンテナ内で実行）
php artisan serve --host=0.0.0.0 --port=8000
```

### dev2（推奨：本番構成に近い環境）

- nginx + PHP-FPM + MySQL + Vue3 + Vite で構成された、本番に近い開発環境です。
- Laravel + Vue の画面開発や、実際の運用に近い動作確認を行う場合は dev2 を標準として利用してください。
- 現在はこちらの dev2 環境を正式な開発環境とみなします。

#### dev2: コンテナの起動

```bash
# コンテナ一式の起動
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 up -d
```

#### dev2: Vite（フロントエンド開発サーバー）の起動

Vue コンポーネントを開発する場合は、app コンテナ内で Vite を起動します。

```bash
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 exec app npm run dev
```

#### dev2: Laravel へのアクセス

ブラウザから次の URL にアクセスします：

```
http://localhost:8080
```

#### dev2: Laravel のコマンドを実行する

```bash
# コンテナ内シェルに入る
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 exec app bash

# 例：マイグレーション実行
php artisan migrate

# その他のコマンド例
php artisan route:list
php artisan tinker
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### dev2: コンテナの停止

```bash
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 down
```

### dev1 / dev2 の使い分け方針

- **通常のアプリ開発・画面開発・本番に近い動作確認**
  → **dev2 を利用（標準）**

- **ちょっとした API 動作確認や、Laravel 単体での挙動を軽く試したいだけのケース**
  → **dev1 を利用**

dev1 と dev2 を併用する場合は、「どちらの環境で起動しているか」を常に意識し、ポート番号や起動コマンドを混同しないようにしてください。

---

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
```
