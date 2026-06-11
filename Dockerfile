FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    pkg-config \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zlib1g-dev \
    libicu-dev \
    default-libmysqlclient-dev \
    libsqlite3-dev \
    sqlite3 \
    nodejs \
    npm \
    nginx \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Configure and install extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg || true
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip intl || true

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first to leverage caching
# If composer.lock isn't present in the repo, copy only composer.json
COPY composer.json ./
RUN composer install --no-dev --optimize-autoloader --no-interaction || true

# Copy application code
COPY . .

# Install frontend deps if present
RUN if [ -f package.json ]; then npm ci --silent && npm run build --silent || true; fi

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default
RUN mkdir -p /etc/nginx/sites-enabled && \
    ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Create supervisor configuration for PHP-FPM and Nginx
RUN mkdir -p /etc/supervisor/conf.d
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8000

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
