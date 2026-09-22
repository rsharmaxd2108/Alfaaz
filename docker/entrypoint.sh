#!/bin/sh
set -e

# Render passes PORT dynamically (e.g. 10000)
PORT=${PORT:-80}
echo "Configuring Nginx to listen on port $PORT..."
sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/http.d/default.conf 2>/dev/null || sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/conf.d/default.conf 2>/dev/null

# Fix storage and public uploads permissions
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/public/uploads/avatars
touch /var/www/html/storage/logs/laravel.log
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads

# Ensure storage link exists
php artisan storage:link || true

# Run migrations if database is configured
if [ -n "$DB_HOST" ] || [ -n "$DATABASE_URL" ]; then
    echo "Running database migrations..."
    # Try normal migrate first; if it fails (broken state), rebuild with migrate:fresh
    if php artisan migrate --force 2>&1; then
        echo "Migrations completed successfully."
    else
        echo "Standard migration failed — running fresh migration..."
        php artisan migrate:fresh --force || echo "Fresh migration also failed; continuing startup."
    fi
    echo "Running database seeder..."
    php artisan db:seed --force || echo "Seeding skipped or failed; continuing startup."
fi

# Cache production config and routes if APP_KEY is set
if [ -n "$APP_KEY" ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting Nginx on port $PORT..."
exec nginx -g "daemon off;"
