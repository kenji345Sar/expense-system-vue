# 経費精算システム（expense-system）

本システムは **Vue.js + Laravel + MySQL + Docker** を用いた経費精算システムです。

下記リポジトリにて、モジュールごとの一覧画面やフォームの共通化により、再利用性の高い構成を目指して開発を進めています。

👉 https://github.com/kenji345Sar/expense-system

---

## 使用技術

- Laravel
- Vue.js
- MySQL
- Docker

---

## 起動方法

```bash
git clone <このリポジトリ>
cd expense-system-vue
cp .env.example .env
# 必要に応じて設定を変更
docker-compose up -d
```

## 現在の開発ブランチと内容
main:feature/module-list-unify
各モジュールの一覧画面を共通化し、再利用可能なレイアウトに統一

feature/unify-form-v2
各モジュールの新規登録・編集画面の共通化対応


