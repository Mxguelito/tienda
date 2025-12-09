# Etapa 1: Construcción
FROM php:8.2-fpm AS build

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Crear carpeta del proyecto
WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Generar cache de Laravel
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache


# Etapa 2: Producción
FROM php:8.2-fpm

WORKDIR /app

# Copiar resultado de la construcción
COPY --from=build /app /app

# Exponer puerto
EXPOSE 8080

# Comando para correr Laravel
CMD php artisan serve --host=0.0.0.0 --port=8080
