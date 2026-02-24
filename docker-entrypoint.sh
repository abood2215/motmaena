#!/bin/bash
set -e

# توليد APP_KEY إذا مش موجود
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# تشغيل migrations (اختياري)
php artisan migrate --force

exec "$@"