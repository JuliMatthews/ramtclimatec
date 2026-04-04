FROM dunglas/frankenphp:php8.3-bookworm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libicu-dev libgd-dev libpng-dev nodejs npm \
    && install-php-extensions intl zip gd bcmath pdo pdo_mysql opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader --no-scripts --no-interaction --ignore-platform-reqs

RUN npm install && npm run build

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

ENV SERVER_NAME=":80"
ENV APP_ENV=production

EXPOSE 80

CMD bash -c "php artisan config:cache && php artisan view:cache && frankenphp run --config /etc/caddy/Caddyfile"