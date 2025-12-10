# Imagen base con Apache
FROM php:8.2-apache

# Instalar extensiones requeridas
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar archivos del proyecto al DOCUMENT ROOT correcto
# Render espera que Laravel viva en /var/www/html, PERO SOLO EL CONTENIDO DE /public debe ser web
COPY . /var/www/laravel

WORKDIR /var/www/laravel

# Instalar dependencias
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

RUN composer install --no-dev --optimize-autoloader

# Copiar el contenido de /public a la carpeta pública de Apache
RUN rm -rf /var/www/html/* \
    && cp -r /var/www/laravel/public/* /var/www/html/ \
    && chown -R www-data:www-data /var/www/html

# Exponer puerto
EXPOSE 8080

# Iniciar Apache
CMD ["apache2-foreground"]
