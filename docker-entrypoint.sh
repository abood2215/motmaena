#!/bin/bash
set -e

cd /var/www/html

php artisan config:clear
php artisan route:clear
php artisan view:clear

# إنشاء ملف SQLite إذا ما كان موجود
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
    echo "✅ SQLite file created"
fi

# تعيين الصلاحيات
chown www-data:www-data /var/www/html/database/database.sqlite
chmod 664 /var/www/html/database/database.sqlite
chmod 775 /var/www/html/database

# تشغيل migrations و seed
php artisan migrate:fresh --force --seed
echo "✅ Database migrated and seeded"

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
