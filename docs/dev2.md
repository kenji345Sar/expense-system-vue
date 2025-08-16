
・git clone
git clone https://github.com/kenji345Sar/expense-system-vue.git expense-system-vue3


# 開発環境


#### 停止・破棄（過去のスタック混在を避ける）
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 down --remove-orphans

#### ビルドして起動
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 up -d --build

#### 起動後のお約束（Laravel 側）
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 exec app php artisan config:clear
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 exec app php artisan route:clear
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 exec app php artisan view:clear

#### 初回 or 変更時：
##### 1) APP_KEY 未設定なら生成
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 exec app php artisan key:generate
##### 2) DBセッション/キャッシュを使うならテーブル作成＆マイグレーション
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 exec app php artisan session:table
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 exec app php artisan cache:table
docker-compose -f docker/dev2/docker-compose.dev.yml -p expense-dev2 exec app php artisan migrate






autload.phpができてない、vendorフォルダができていない
 ![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/176603/a123c643-8c81-4af1-819b-a8a2254f8051.png)

```
docker exec -it dev2-app-1 bash
```
composerでできる、COPYができていない、ここで行う
```
composer install
```

![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/176603/cd3a77cb-86b8-4f37-8b27-02d7c176b687.png)

![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/176603/0bc5935e-57b6-4a5e-89d7-d892bba87656.png)

.envなし
![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/176603/601cb27a-0c1b-4459-afa3-4b5acbee1161.png)

ログでエラー確認
```
docker exec -it dev2-app-1 bash
cat storage/logs/laravel.log

![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/176603/aca76222-d4e8-458f-b13a-1a530ddccc77.png)
```
root@fd1cc7ab62f5:/var/www/html# npm install && npm run build

added 228 packages, and audited 229 packages in 52s

50 packages are looking for funding
  run `npm fund` for details

2 vulnerabilities (1 low, 1 critical)

To address all issues, run:
  npm audit fix

Run `npm audit` for details.

> build
> vite build

vite v6.3.4 building for production...
✓ 74 modules transformed.
public/build/manifest.json              0.27 kB │ gzip:  0.15 kB
public/build/assets/app-BPcKXzbg.css   39.96 kB │ gzip:  7.26 kB
public/build/assets/app-DEjK_ssX.js   266.97 kB │ gzip: 96.07 kB
✓ built in 10.90s
```

loginに繋がった

![image.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/176603/f6a24c33-7145-4333-8cca-127c9240f7a6.png)


コンテナ、ボリューム削除
```
apple@appurunoMacBook-Pro expense-system-vue3 %  docker-compose -f docker/dev2/docker-compose.dev.yml down -v
[+] Running 5/5
 ✔ Container dev2-web-1    Removed                                         0.4s 
 ✔ Container dev2-app-1    Removed                                         0.7s 
 ✔ Container dev2-mysql-1  Removed                                         2.9s 
 ✔ Volume dev2_dbdata      Removed                                         0.2s 
 ✔ Network dev2_laravel    Removed                                         0.2s 
apple@appurunoMacBook-Pro expense-system-vue3 % 
```
