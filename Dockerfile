FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo_mysql sockets

WORKDIR /app

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

COPY . .

RUN composer install

RUN chmod -R 777 /app/storage/logs/