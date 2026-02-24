#!/bin/bash

cd /var/www/html

php artisan config:cache || true
php artisan route:cache  || true
php artisan view:cache   || true
php artisan migrate --force || true
php artisan db:seed --force || true

exec "$@"