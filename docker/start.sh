#!/bin/bash
set -e

# Railway sets PORT; Apache listens on 8080 by default in our config â€” map Listen
PORT="${PORT:-8080}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf || true
sed -i "s/\*:8080/*:${PORT}/" /etc/apache2/sites-available/000-default.conf || true

if [ -z "$APP_KEY" ]; then
  echo "APP_KEY is missing"
fi

php artisan config:clear || true
php artisan storage:link || true
php artisan migrate --force || true
php artisan db:seed --force || true

apache2-foreground
