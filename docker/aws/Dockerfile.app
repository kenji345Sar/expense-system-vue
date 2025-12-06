# --- 1) assets build ---
FROM node:18-bullseye AS assets
WORKDIR /app
COPY package*.json vite.config.* ./
RUN npm ci
COPY resources ./resources
COPY public ./public
RUN npm run build

# --- 2) vendor build ---
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# --- 3) runtime ---
FROM php:8.2-fpm-bullseye
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y git unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rw storage bootstrap/cache
