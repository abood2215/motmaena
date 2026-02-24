FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip

RUN docker-php-ext-install pdo pdo_mysql zip

# تفعيل mod_rewrite
RUN a2enmod rewrite

# تغيير مجلد Apache إلى public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php \
 && php composer.phar install --no-dev --optimize-autoloader

RUN php artisan key:generate || true

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80