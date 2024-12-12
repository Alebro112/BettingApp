FROM php:8.2-fpm
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#WORKDIR /var/www

COPY composer.json composer.json
COPY . /var/www/html
RUN composer dump-autoload --optimize --classmap-authoritative
