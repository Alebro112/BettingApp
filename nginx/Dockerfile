FROM php:8.2-fpm
#RUN docker-php-ext-install mysqli
#RUN docker-php-ext-enable mysqli
RUN composer install --no-autoloader

# FROM ubuntu

# RUN apt-get update


FROM nginx
COPY ./default.conf /etc/nginx/conf.d/default.conf

#######
