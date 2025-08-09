FROM php:8.2-fpm

# 必要なパッケージをインストール + Node.js を追加
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer インストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www/html

# アプリケーションコードをコピー
COPY . .

# Laravel の依存関係をインストール
RUN composer install --optimize-autoloader --no-dev \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# フロントエンドのビルド（Node.js/NPM）
RUN npm install && npm run build

# php-fpm の設定変更（Nginxから接続可能に）
RUN sed -i 's/^listen = 127\.0\.0\.1:9000/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf

# コンテナ起動時のコマンド
CMD ["php-fpm"]
