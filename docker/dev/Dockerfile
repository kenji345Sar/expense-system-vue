# Dockerfile
FROM php:8.2-fpm

# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
  git \
  curl \
  zip \
  unzip \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  libzip-dev \
  && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Node.js をインストール（Debianベース想定）
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
  && apt-get install -y nodejs

# Composer インストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www/html

# 権限とユーザー設定（オプション）
RUN chown -R www-data:www-data /var/www/html

# 起動用コマンドは docker-compose 側で制御
