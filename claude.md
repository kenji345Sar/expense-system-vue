# Claude Code プロジェクトガイドライン

このファイルは Claude Code がこのリポジトリで作業する際のルール・手順書です。  
必ず以下の方針に従って行動してください。

---

## 0. 作業ディレクトリ（重要）

- 常に **リポジトリのルート** を作業ディレクトリとすること。
- ルートの例：じゃあ、Claude Code 用の「安全運転マニュアル（claude.md）」を丸ごと用意しますね。
これを**リポジトリ直下に `claude.md` として置く**だけで OK です。

---

## 置き方

1. VS Code などでプロジェクトのルートを開く
   （`composer.json` と `vite.config.js` があるディレクトリ）
2. そこに **`claude.md`** というファイル名で保存
3. 下の内容をそのまま貼り付け

---

## claude.md（提案内容）

````markdown
# Claude Code プロジェクトガイドライン

このファイルは Claude Code がこのリポジトリで作業する際のルール・手順書です。  
必ず以下の方針に従って行動してください。

---

## 0. 作業ディレクトリ（重要）

- 常に **リポジトリのルート** を作業ディレクトリとすること。
- ルートの例：
  - `composer.json`
  - `package.json`
  - `vite.config.js`
  - `docker/` ディレクトリ
- **絶対に別プロジェクトのパスに移動しないこと。**
  - 特に `/Users/apple/Desktop/Site/claude-project` 等には移動しない。

### コマンド実行前の確認

すべてのシェルコマンド実行前に、次を実行して現在地を確認すること：

```bash
pwd
ls
````

`composer.json` や `vite.config.js` が見えるディレクトリでのみ作業する。

---

## 1. 開発環境の構成

このリポジトリには **2 種類の開発環境** がある。

### 1-1. dev1（最小構成 Laravel 環境）

* シンプルな Laravel のみの環境。
* 主な用途：

  * API 単体の検証や軽いテスト。
* 起動方法の例（参考程度）：

  * `php artisan serve`
  * `npm run dev`
* 今回の標準開発環境では **dev2 を優先** する。
  dev1 を使う場合は、ユーザーから明示的な指示があるときのみ。

### 1-2. dev2（推奨：本番構成に近い環境）

* nginx + PHP-FPM + MySQL + Vue3 + Vite 構成。
* docker を使って起動する。
* 主に利用するファイル：

  * `docker/dev2/docker-compose.dev.yml`
  * `docker/dev2/Dockerfile`
  * `docker/dev2/nginx.conf`

#### dev2 の起動手順（標準）

1. **コンテナを起動**

```bash
docker compose -f docker/dev2/docker-compose.dev.yml up -d
```

2. **（初回のみ）依存関係インストール**

```bash
docker compose -f docker/dev2/docker-compose.dev.yml exec dev2-app-1 composer install
docker compose -f docker/dev2/docker-compose.dev.yml exec dev2-app-1 npm install
```

3. **フロントエンド開発サーバ（Vite）起動**

```bash
docker compose -f docker/dev2/docker-compose.dev.yml exec dev2-app-1 npm run dev
```

4. **アクセス URL**

* Laravel アプリ（nginx 経由）
  → `http://localhost:8080`
* Vite 開発サーバ（必要に応じて）
  → `http://localhost:5173` など、`vite.config.js` で指定されたポート

#### dev2 の停止

```bash
docker compose -f docker/dev2/docker-compose.dev.yml down
```

---

## 2. Claude Code が触ってよい／いけない場所

### 2-1. 原則として **触ってよい** 場所

* アプリケーションコード

  * `app/`
  * `routes/`
  * `resources/views/`
  * `resources/js/` など
* 設定・インフラ関連（必要に応じて）

  * `config/`
  * `docker/dev2/` 配下
* ドキュメント

  * `README.md`
  * その他、ユーザーが明示的に編集を指示した Markdown / テキストファイル

### 2-2. **ユーザーの明示的な指示がない限り変更してはいけない** ファイル／ディレクトリ

* `.env` 系ファイル

  * `.env`
  * `.env.example`
  * `.env.aws`
* ロックファイル

  * `package-lock.json`
  * `composer.lock`
* ビルド成果物・依存物

  * `node_modules/`
  * `vendor/`
  * `public/build/` 等のビルドディレクトリ
* Git 管理関連

  * `.git/`
  * `.gitignore`
* バックアップや一時ファイル

  * `*.bak`
  * `*.tmp`

これらを変更する必要がある場合は、**必ずユーザーに「このファイルを変更してよいか」確認**し、理由を説明すること。

---

## 3. git 操作のルール

### 3-1. コミット前の確認

1. `git status` を実行して変更ファイルを確認。
2. `git diff` または `git diff --stat` を実行し、どのファイルがどの程度変わっているかを把握。
3. 大量行数の変更が発生している場合（数百行以上）は、

   * 本当に必要な変更かどうかを再確認する。
   * ロックファイルや `.env` を含んでいないか確認する。

### 3-2. コミット時のガイドライン

* コミットメッセージは **要約 + 目的** を日本語または英語で簡潔に書く。

  * 例：`Add dev1/dev2 environment guide to README`
  * 例：`Fix dev2 docker-compose port mapping for nginx`
* 1 つのコミットには **関連する変更だけ** を含める。
  ドキュメント修正とコード修正は可能なら分ける。

### 3-3. 不要な変更の巻き戻し

* 間違って `.env.aws` や `package-lock.json` を変更してしまった場合：

```bash
git restore .env.aws package-lock.json
```

* すでにコミットしてしまった場合は、ユーザーに報告し、
  「不要な変更を取り消すためのコミット」を新たに作成する。

---

## 4. 作業スタイルの方針

1. **まず現状を読む**

   * README や `docker/dev2/docker-compose.dev.yml` を確認して、
     既に書かれている手順や方針を上書きしないように注意する。
2. **小さく試す**

   * いきなり大規模なリファクタリングを行わず、
     まずは小さな変更で動作確認する。
3. **ログ・エラーは丁寧に読む**

   * 例えばポート競合や MySQL 接続エラーなどは、
     エラーメッセージを日本語に噛み砕いてユーザーに説明する。
4. **ドキュメントを更新する**

   * 環境構築手順や起動コマンドに変更を加えた場合は、
     必ず `README.md` や関連ドキュメントも合わせて更新する。

---

## 5. よくあるタスク例

### 5-1. dev2 環境を使ってアプリを起動・確認する

1. `pwd` でリポジトリルートにいることを確認。
2. `docker compose -f docker/dev2/docker-compose.dev.yml up -d` を実行。
3. 必要なら `npm install` / `composer install` を dev2-app-1 コンテナ内で実行。
4. `docker compose -f docker/dev2/docker-compose.dev.yml exec dev2-app-1 npm run dev` を実行。
5. ブラウザで `http://localhost:8080` にアクセスして画面を確認。

### 5-2. README に dev1/dev2 の説明を追記する

* 既存のセクション構成を壊さずに、「dev1（最小構成）」「dev2（推奨）」の違いが分かるように記載する。
* 実際に実行したコマンド・確認できた URL を具体的に書く。

---

## 6. ユーザーとのコミュニケーション

* あいまいな点がある場合は、**勝手に推測して大きく変更するのではなく、質問する。**
* 特に以下の場合は必ず確認を取ること：

  * 環境全体の構成を変える提案（例：ポート番号の変更、DB の差し替え等）
  * `.env` やロックファイルの変更
  * 既存の大きな仕様を変更するようなリファクタリング提案
* その上で、
  「今からやろうとしていること」「影響範囲」「ロールバック方法」を簡単に説明する。

---

このガイドラインに従って、
**安全かつ段階的に** このプロジェクトの開発を支援してください。

```
