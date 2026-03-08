#!/bin/bash
set -e

# Copy .env.example if .env does not exist
if [ ! -f ".env" ]; then
    cp .env.example .env
fi

# Generate application key if not set
php artisan key:generate --force

# Create the sqlite database file if it doesn't exist
if [ ! -f "database/database.sqlite" ]; then
    touch database/database.sqlite
fi

# Run database migrations
php artisan migrate --force

# Run database seeders (optional)
# php artisan db:seed --force

# Clear caches
php artisan optimize:clear

# Set proper permissions just in case mounted volumes messed it up
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

exec "$@"
