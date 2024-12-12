FROM php:8.2-fpm

# Install and enable php extensions
RUN docker-php-ext-install mysqli

# Install composer

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer


COPY . .
RUN composer update
RUN composer install
RUN composer dump-autoload