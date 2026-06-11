#!/bin/sh
set -e

# Prepare application (safe, idempotent)
if [ -f artisan ]; then
  # If using SQLite, ensure the database file exists at a Linux-friendly path
  if [ "${DB_CONNECTION:-}" = "sqlite" ] || [ -z "${DB_CONNECTION:-}" ]; then
    # default sqlite path inside container
    SQLITE_DB_PATH=${DB_DATABASE:-/var/www/html/database/database.sqlite}
    export DB_DATABASE="$SQLITE_DB_PATH"
    mkdir -p "$(dirname "$SQLITE_DB_PATH")"
    if [ ! -f "$SQLITE_DB_PATH" ]; then
      touch "$SQLITE_DB_PATH" || true
    fi
    chown -R www-data:www-data "$(dirname "$SQLITE_DB_PATH")" || true
    chmod 664 "$SQLITE_DB_PATH" || true
  fi

  php artisan key:generate --force || true
  # run migrations (will use DB_DATABASE env we exported)
  php artisan migrate --force || true
  php artisan storage:link || true
  php artisan config:cache || true
  php artisan route:cache || true
  php artisan view:cache || true
fi

exec "$@"
