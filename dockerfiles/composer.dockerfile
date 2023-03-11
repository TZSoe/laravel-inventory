FROM composer:latest

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

ENTRYPOINT ["composer"]