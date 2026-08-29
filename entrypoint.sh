#!/bin/bash

# Give full permissions to storage and database directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod 664 /var/www/html/database/database.sqlite

# Clear config and cache
php artisan config:clear
php artisan cache:clear

# Run database migrations
php artisan migrate --force

# Start Apache
apache2-foreground