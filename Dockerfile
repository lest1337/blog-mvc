FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && pecl install pdo_sqlite \
    && docker-php-ext-enable pdo_sqlite \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql mysqli zip

RUN a2enmod rewrite

COPY --chown=www-data:www-data . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
