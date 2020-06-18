FROM php:7.4.7-apache
RUN apt-get update
RUN apt-get install curl
COPY ./setup /usr/local/setup
ADD ./pages /var/www/html
RUN a2enmod rewrite
RUN a2enmod autoindex
COPY ./000-default.conf /etc/apache2/sites-available/