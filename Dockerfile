FROM php:fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

COPY ./config/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
