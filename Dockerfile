# vendor
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-dev --prefer-dist --no-scripts
COPY . .
RUN composer dump-autoload -o

# assets
FROM node:18-bullseye AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci --no-audit --fund=false
COPY . .
RUN npm run build

# runtime
FROM php:8.2-fpm
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build
RUN chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache
ENV APP_ENV=production
CMD ["php-fpm"]
