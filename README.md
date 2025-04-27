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
