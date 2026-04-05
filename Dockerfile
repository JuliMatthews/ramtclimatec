FROM dunglas/frankenphp:php8.3-bookworm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libicu-dev libgd-dev libpng-dev \
    && install-php-extensions intl zip gd bcmath pdo pdo_mysql opcache \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader --no-scripts --no-interaction --ignore-platform-reqs

RUN npm install && npm run build

RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

RUN php artisan vendor:publish --tag=filament-assets --force
RUN php artisan vendor:publish --tag=livewire:assets --force

ENV SERVER_NAME=":80"
ENV APP_ENV=production
ENV FRANKENPHP_DOCUMENT_ROOT=/app/public

EXPOSE 80

CMD bash -c "php artisan migrate --force && php artisan storage:link && php artisan filament:upgrade && php artisan config:cache && php artisan view:cache && frankenphp run --config /etc/caddy/Caddyfile"