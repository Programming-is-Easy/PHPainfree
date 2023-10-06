FROM php:8.1.12-apache

RUN apt-get update && apt-get install -y git zip unzip libzip-dev libpng-dev
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-enable mysqli
RUN docker-php-ext-install gd && docker-php-ext-enable gd
RUN docker-php-ext-install bcmath && docker-php-ext-enable bcmath
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
RUN mkdir -p /var/www/vhosts/phpainfree

COPY httpd-docker-local.conf /etc/apache2/sites-available/000-default.conf
#COPY php.ini /usr/local/etc/php/

ENV APACHE_DOCUMENT_ROOT /var/www/vhosts/phpainfree/htdocs
ENV TZ UTC

# set correct DocumentRoot in all .conf files
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# set correct timezone in the container
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

