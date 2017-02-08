FROM php:7.0-apache

RUN apt-get update && apt-get install -y \
        libpq-dev \
        php-amqplib

RUN docker-php-source extract \
    && docker-php-ext-install -j$(nproc) bcmath \
    && docker-php-source delete

ADD html /var/www/html
ADD platform/php.ini /usr/local/etc/php/php.ini
