#!/bin/sh
set -e

# Render passes PORT dynamically (e.g. 10000)
PORT=${PORT:-80}
echo "Configuring Nginx to listen on port $PORT..."
sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/http.d/default.conf 2>/dev/null || sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/conf.d/default.conf 2>/dev/null

# Fix storage and public uploads permissions
mkdir -p /var/www/html/public/uploads/avatars
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/uploads

# Ensure storage link exists
php artisan storage:link || true

# Run migrations if database is configured
if [ -n "$DB_HOST" ] || [ -n "$DATABASE_URL" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || echo "Migration skipped or failed; continuing startup."
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
