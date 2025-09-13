# Run on AWS (Amazon Linux 2023)

このスクリプトは **Laravel + Vue** のポートフォリオを **Amazon Linux 2023 + Nginx + PHP-FPM** に最短でセットアップします。
毎回 scp せず、**EC2 から GitHub の最新版を直接実行**する運用を想定しています。

---

## 前提

-   OS: Amazon Linux 2023
-   セキュリティグループ: 22/tcp（SSH）, 80/tcp（HTTP）を許可
-   リポジトリ: `https://github.com/kenji345Sar/expense-system-vue`
    （**公開**で運用推奨。非公開の場合はトークンが必要）

---

## 1. 一度もクローンしていない場合（クイック実行）

> 最新のスクリプトを **1 行**でダウンロード → 実行します。

```bash
curl -fsSL https://raw.githubusercontent.com/kenji345Sar/expense-system-vue/main/setup_laravel_vue_ec2.sh \
  -o ~/setup_laravel_vue_ec2.sh && \
chmod +x ~/setup_laravel_vue_ec2.sh && \
sudo bash ~/setup_laravel_vue_ec2.sh
```
