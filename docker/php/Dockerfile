FROM php:8.2-fpm
#WORKDIR /var/www


RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.json
COPY . .
RUN composer install
RUN composer dump-autoload