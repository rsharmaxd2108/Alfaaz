#!/bin/sh

# Render passes PORT dynamically (e.g. 10000)
PORT=${PORT:-80}
echo "Configuring Nginx to listen on port $PORT..."
sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/http.d/default.conf 2>/dev/null || sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/conf.d/default.conf 2>/dev/null || true

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
php artisan storage:link 2>/dev/null || true

# Run migrations if database is configured
if [ -n "$DB_HOST" ] || [ -n "$DATABASE_URL" ]; then
    echo "========================================="
    echo "DATABASE SETUP START"
    echo "DB_HOST: $DB_HOST"
    echo "DB_PORT: $DB_PORT"
    echo "DB_DATABASE: $DB_DATABASE"
    echo "DB_CONNECTION: $DB_CONNECTION"
    echo "========================================="

    echo "Dropping all tables and running fresh migration with seed..."
    php artisan migrate:fresh --seed --force -v 2>&1
    MIGRATE_EXIT=$?
    echo "Migration exit code: $MIGRATE_EXIT"

    if [ $MIGRATE_EXIT -ne 0 ]; then
        echo "!!! MIGRATION FAILED !!!"
        echo "Checking laravel.log for details..."
        tail -50 /var/www/html/storage/logs/laravel.log 2>/dev/null || echo "No log file found"
    else
        echo "Migration and seeding completed successfully!"
    fi

    echo "========================================="
    echo "DATABASE SETUP END"
    echo "========================================="
fi

# Cache production config and routes if APP_KEY is set
if [ -n "$APP_KEY" ]; then
    php artisan config:cache 2>/dev/null || true
    php artisan route:cache 2>/dev/null || true
    php artisan view:cache 2>/dev/null || true
fi

echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting Nginx on port $PORT..."
exec nginx -g "daemon off;"
