FROM php:8.2-fpm
#WORKDIR /var/www


ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

WORKDIR /var/www

COPY composer.json composer.json
COPY . .
RUN composer install
RUN composer dump-autoload