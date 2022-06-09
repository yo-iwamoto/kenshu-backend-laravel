FROM php:8.1.5-fpm

WORKDIR /kenshu-backend-laravel

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y git libzip-dev

RUN docker-php-ext-install pdo_mysql
