FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    libjpeg62-turbo-dev \
    libpng-dev

RUN docker-php-ext-install gd
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs
# Extension for mock uploadfile

# Extension mysql driver for mysql
RUN docker-php-ext-install pdo_mysql mysqli
RUN chown -R www-data:www-data /var/www
