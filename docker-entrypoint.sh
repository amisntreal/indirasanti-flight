#!/bin/sh
set -e

# Wait for MySQL
echo "Waiting for MySQL..."
until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -e "SELECT 1" > /dev/null 2>&1; do
    sleep 2
done
echo "MySQL is ready."

# Run migrations and seed
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link || true

exec "$@"
