#!/bin/bash

# Clear configuration cache to make sure environment variables are read properly
php artisan config:clear
php artisan cache:clear

# Run database migrations automatically on startup
php artisan migrate --force

# Start Apache in the foreground
apache2-foreground