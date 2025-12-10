# Imagen base oficial PHP + Apache
FROM php:8.2-apache

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar archivos del proyecto
COPY . /var/www/html

# Definir directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias del proyecto
RUN composer install --no-dev --optimize-autoloader

# Laravel necesita permisos para storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Cachear config, rutas y vistas
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Apache debe escuchar el puerto que Render asigna (8080)
EXPOSE 8080

# Iniciar el servidor web
CMD ["apache2-foreground"]
