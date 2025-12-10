# Etapa 1: Build
FROM php:8.2-fpm AS build

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# limpiar caches antes de compilar
RUN php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan route:clear

# compilar caches
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# generar link de storage
RUN php artisan storage:link || true

# permisos
RUN chmod -R 777 storage bootstrap/cache


# Etapa 2: Runtime
FROM php:8.2-fpm

WORKDIR /app
COPY --from=build /app /app

EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=8080
