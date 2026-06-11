#!/bin/sh
set -e

# Prepare application (safe, idempotent)
if [ -f artisan ]; then
  php artisan key:generate --force || true
  php artisan migrate --force || true
  php artisan storage:link || true
  php artisan config:cache || true
  php artisan route:cache || true
  php artisan view:cache || true
fi

exec "$@"
