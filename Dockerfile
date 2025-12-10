# Etapa 1: Build
FROM php:8.2-fpm AS build

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# IMPORTANTE: NO ejecutar artisan en el build
# Laravel no tiene .env aún en esta etapa → falla

# Etapa 2: Runtime final
FROM php:8.2-fpm

WORKDIR /app
COPY --from=build /app /app

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080
