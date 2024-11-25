FROM php:8.3-fpm

RUN apt-get update  \
    && apt-get install -y git \
    && apt-get install -y zip \
    && apt-get install -y curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

CMD php-fpm
