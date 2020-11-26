FROM php:7.4-fpm

RUN apt-get update && apt-get upgrade -y
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs
# Extension mysql driver for mysql
RUN docker-php-ext-install pdo_mysql mysqli
RUN chown -R www-data:www-data /var/www
