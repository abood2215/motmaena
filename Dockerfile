FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip curl \
    && docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
COPY . .

RUN curl -sS https://getcomposer.org/installer | php \
    && php composer.phar install --no-dev --optimize-autoloader

RUN a2enmod rewrite

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN php artisan key:generate || true

EXPOSE 80