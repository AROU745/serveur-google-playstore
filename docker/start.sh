#!/bin/bash
set -e

# Railway sets PORT; map Apache Listen + VirtualHost
PORT="${PORT:-8080}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf || true
sed -i "s/\*:8080/*:${PORT}/" /etc/apache2/sites-available/000-default.conf || true

# Ensure only one MPM (mod_php requires prefork)
a2dismod mpm_event 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true
a2enmod rewrite 2>/dev/null || true

if [ -z "$APP_KEY" ]; then
  echo "APP_KEY is missing"
fi

php artisan config:clear || true
php artisan storage:link --force 2>/dev/null || php artisan storage:link || true
php artisan migrate --force || true
php artisan db:seed --force || true

exec apache2-foreground
