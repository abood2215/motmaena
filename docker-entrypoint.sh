#!/bin/bash
set -e

cd /var/www/html

php artisan config:clear
php artisan route:clear
php artisan view:clear

# تشغيل migrations و seed
php artisan migrate:fresh --force --seed
echo "✅ Database migrated and seeded"

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
