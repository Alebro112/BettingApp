FROM php:8.2-fpm
COPY . .
RUN composer install
RUN composer dump-autoload


# FROM ubuntu

# RUN apt-get update


FROM nginx
COPY ./default.conf /etc/nginx/conf.d/default.conf

#######
