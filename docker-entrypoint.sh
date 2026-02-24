#!/bin/bash

cd /var/www/html

php artisan config:cache || true
php artisan config:clear || true
php artisan route:cache  || true
php artisan route:clear || true
php artisan view:cache   || true
php artisan view:clear || true

# Refresh database (drop and recreate)
php artisan migrate:fresh --force --seed || true

exec "$@"