#!/usr/bin/env bash
set -euo pipefail

# ===== 設定 =====
GIT_REPO="https://github.com/kenji345Sar/expense-system-vue.git"
BRANCH="main"
RESET=true

APP_BASE="/var/www/laravel"
APP_DIR="${APP_BASE}/app"
NGX_MAIN="/etc/nginx/nginx.conf"
NGX_SITE="/etc/nginx/conf.d/laravel.conf"

# PHP-FPM 実ユーザー/グループ（無ければ apache）
PHPFPM_USER="$(awk -F'= *' '/^user *=/ {print $2}' /etc/php-fpm.d/www.conf 2>/dev/null || echo apache)"
PHPFPM_GROUP="$(awk -F'= *' '/^group *=/ {print $2}' /etc/php-fpm.d/www.conf 2>/dev/null || echo apache)"
[ -z "$PHPFPM_USER" ] && PHPFPM_USER=apache
[ -z "$PHPFPM_GROUP" ] && PHPFPM_GROUP=apache

echo "== 0) curl 競合を事前解消 =="
sudo dnf -y swap curl-minimal curl || sudo dnf -y install curl --allowerasing || true

echo "== 1) パッケージ =="
sudo dnf -y update
sudo dnf -y install \
  nginx php-cli php-fpm php-mbstring php-xml php-bcmath php-json php-opcache \
  unzip git curl nodejs

# Composer
if ! command -v composer >/dev/null 2>&1; then
  php -r "copy('https://getcomposer.org/installer','composer-setup.php')"
  php composer-setup.php --install-dir=/usr/local/bin --filename=composer
  rm -f composer-setup.php
fi

echo "== 2) アプリ配備（RESET=${RESET}) =="
sudo mkdir -p "${APP_BASE}"
sudo chown ec2-user:ec2-user "${APP_BASE}"
if [ "${RESET}" = "true" ] && [ -d "${APP_DIR}" ]; then
  sudo rm -rf "${APP_DIR}"
fi
git clone -b "${BRANCH}" --depth 1 "${GIT_REPO}" "${APP_DIR}"
cd "${APP_DIR}"

echo "== 3) .env を用意 =="
[ -f .env ] || cp .env.example .env
sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env || true
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env || true

echo "== 4) まずは SQLite で表示できる状態に =="
mkdir -p database && touch database/database.sqlite
if grep -q '^DB_CONNECTION=' .env; then sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env; else echo 'DB_CONNECTION=sqlite' >> .env; fi
if grep -q '^DB_DATABASE=' .env; then sed -i 's#^DB_DATABASE=.*#DB_DATABASE='"${APP_DIR}"'/database/database.sqlite#' .env; else echo "DB_DATABASE=${APP_DIR}/database/database.sqlite" >> .env; fi

echo "== 4.1) セッションは file にして DB 依存を無くす（A デフォルト） =="
if grep -q '^SESSION_DRIVER=' .env; then
  sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
else
  echo 'SESSION_DRIVER=file' >> .env
fi
mkdir -p "${APP_DIR}/storage/framework/{sessions,cache,views}"

echo "== 5) 依存インストール & Vite ビルド =="
composer install --no-dev --optimize-autoloader
if [ -f package-lock.json ]; then npm ci || npm install; else npm install; fi
npm run build

echo "== 6) Nginx 最小構成 =="
sudo cp "${NGX_MAIN}" "${NGX_MAIN}.bak.$(date +%s)" || true
sudo tee "${NGX_MAIN}" >/dev/null <<'EOF'
user nginx;
worker_processes auto;
error_log /var/log/nginx/error.log notice;
pid /run/nginx.pid;
events { worker_connections 1024; }
http {
  include /etc/nginx/mime.types;
  default_type application/octet-stream;
  log_format main '$remote_addr - $remote_user [$time_local] "$request" '
                  '$status $body_bytes_sent "$http_referer" '
                  '"$http_user_agent" "$http_x_forwarded_for"';
  access_log /var/log/nginx/access.log main;
  sendfile on;
  keepalive_timeout 65;
  include /etc/nginx/conf.d/*.conf;
}
EOF

sudo tee "${NGX_SITE}" >/dev/null <<EOF
server {
  listen 80 default_server;
  server_name _;
  root ${APP_DIR}/public;
  index index.php index.html;

  location / { try_files \$uri \$uri/ /index.php?\$query_string; }

  location ~ \.php\$ {
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
    fastcgi_param DOCUMENT_ROOT   \$realpath_root;
    fastcgi_pass unix:/run/php-fpm/www.sock;
  }

  location ~* \.(jpg|jpeg|png|gif|svg|css|js|ico|woff2?)\$ {
    expires max;
    access_log off;
  }
}
EOF

# 余計な default 設定を除去
sudo rm -f /etc/nginx/default.d/php.conf 2>/dev/null || true

echo "== 7) 権限（順序重要） =="
# コードは ec2-user（artisan が .env を書けるように）
sudo chown -R ec2-user:ec2-user "${APP_DIR}"
sudo find "${APP_DIR}" -type d -exec chmod 755 {} \;
sudo find "${APP_DIR}" -type f -exec chmod 644 {} \;

# 書き込み系は php-fpm ユーザーに
sudo mkdir -p "${APP_DIR}/storage/logs"
sudo touch "${APP_DIR}/storage/logs/laravel.log"
sudo chown -R "${PHPFPM_USER}:${PHPFPM_GROUP}" "${APP_DIR}/storage" "${APP_DIR}/bootstrap/cache"
sudo find "${APP_DIR}/storage" "${APP_DIR}/bootstrap/cache" -type d -exec chmod 775 {} \;
sudo find "${APP_DIR}/storage" "${APP_DIR}/bootstrap/cache" -type f -exec chmod 664 {} \;

echo "== 8) APP_KEY を必ず生成 =="
cd "${APP_DIR}"
php artisan key:generate --force || true

echo "== 9) サービス起動 & キャッシュ整理 =="
sudo systemctl enable php-fpm nginx
sudo nginx -t
sudo systemctl restart php-fpm
sudo systemctl restart nginx

php artisan config:clear || true
php artisan cache:clear  || true
php artisan route:clear  || true
php artisan view:clear   || true

TOKEN=$(curl -s -X PUT "http://169.254.169.254/latest/api/token" -H "X-aws-ec2-metadata-token-ttl-seconds: 60" || true)
PUBIP=$(curl -s -H "X-aws-ec2-metadata-token: ${TOKEN:-}" http://169.254.169.254/latest/meta-data/public-ipv4 || echo "<EC2-Public-IP>")
echo
echo "==============================================="
echo " ✅ 完了: http://${PUBIP}"
echo "    プロジェクト: ${APP_DIR}"
echo "    PHP-FPM USER: ${PHPFPM_USER}:${PHPFPM_GROUP}"
echo "    ビルド資産:   ${APP_DIR}/public/build"
echo "==============================================="
