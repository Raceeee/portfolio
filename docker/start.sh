#!/usr/bin/env bash
set -e

echo "Clearing any stale cached config..."
php artisan config:clear || true

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Linking storage..."
php artisan storage:link || true

echo "Running database migrations..."
php artisan migrate --force

echo "Seeding profile/admin data..."
php artisan db:seed --force

echo "Starting services..."
exec supervisord -c /etc/supervisord.conf