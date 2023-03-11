FROM php:8.2.0-fpm

WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install pdo pdo_mysql 

RUN apt-get update && \
    apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd


RUN chown -R www-data:www-data /var/www/html