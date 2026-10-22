#!/usr/bin/env bash
# Deploy latest master to the production server.
# Usage (on the server): cd /var/www/motmaena && bash deploy.sh

# Wrapped in a function so bash parses the whole script before running it;
# `git pull` may rewrite this file mid-run.
main() {
    set -euo pipefail

    cd "$(dirname "$(readlink -f "$0")")"

    echo "==> Pulling latest code..."
    git pull

    echo "==> Installing PHP dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction

    echo "==> Running migrations..."
    php artisan migrate --force

    echo "==> Building frontend assets..."
    npm ci --no-audit --no-fund
    npm run build

    echo "==> Caching config, routes and views..."
    php artisan optimize:clear
    php artisan optimize

    echo "==> Fixing permissions..."
    chown -R www-data:www-data storage bootstrap/cache

    # PHP-FPM's OPcache keeps serving the old compiled code until reloaded
    echo "==> Reloading PHP-FPM..."
    for svc in $(systemctl list-units --type=service --no-legend | grep -o 'php[0-9.]*-fpm' | sort -u); do
        systemctl reload "$svc"
    done

    echo "==> Deployed: $(git log --oneline -1)"
}

main "$@"
