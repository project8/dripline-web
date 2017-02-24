FROM php:7.0-apache

RUN apt-get update && apt-get install -y \
        libpq-dev \
        php-amqplib \
        ssl-cert

RUN make-ssl-cert generate-default-snakeoil &&\
    a2enmod ssl &&\
    ln -s /etc/apache2/sites-available/default-ssl.conf /etc/apache2/sites-enabled/default-ssl.conf

RUN docker-php-source extract \
    && docker-php-ext-install -j$(nproc) bcmath \
    && docker-php-source delete

ADD src /var/www/html/dripline-web
ADD platform/php.ini /usr/local/etc/php/php.ini
