FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip pdo_mysql

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html 