# expense-system 環境構築手順（Sailなし版）

このプロジェクトはもともと Laravel Sail を使っていましたが、  
現在は Sail を使わず、Docker Compose で直接管理しています。

## 環境構成

- Laravel
- MySQL
- Redis
- Mailpit
- Selenium
- Meilisearch（※使用しない場合はdocker-compose.ymlから除去可能）

## 必要なツール

- Docker
- Docker Compose
- Git

## セットアップ手順

1. プロジェクトをクローン

```bash
git clone https://github.com/kenji345Sar/expense-system.git
cd expense-system


# 🖊 MacからWindowsへのデータベース対応について

- Mac側で MySQL データベース `laravel` から `dump.sql` を作成し、GitHubにpushしました。
- Windows側では以下手順で環境を揃えています。

### 手順

1. GitHubから最新を取得
    ```bash
    git pull
    ```

2. dump.sql を MySQLコンテナにコピー
    ```bash
    docker cp dump.sql expense-system-mysql-1:/dump.sql
    ```

3. MySQLコンテナに入る
    ```bash
    docker exec -it expense-system-mysql-1 bash
    ```

4. dump.sql をインポート
    ```bash
    mysql -u root -p laravel < /dump.sql
    ```

（パスワードは `.env` に設定されているものを使用）

