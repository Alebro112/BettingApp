FROM nginx
COPY ./default.conf /etc/nginx/conf.d/default.conf

#######

FROM ubuntu

RUN apt-get update
RUN composer install --no-autoloader