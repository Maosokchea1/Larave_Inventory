#!/bin/sh
set -e

# Run database migrations automatically on start
php artisan migrate --force

# Clear and cache configurations for high performance
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache web server in foreground
exec apache2-foreground