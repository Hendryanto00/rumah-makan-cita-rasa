# Multi-stage build untuk Laravel
FROM node:20-alpine AS node-builder

# Install dependencies untuk build assets
WORKDIR /app
COPY package*.json ./
RUN npm ci

# Copy source files
COPY . .

# Build assets
RUN npm run build

# Stage 2: PHP dengan Nginx
FROM php:8.2-fpm-alpine AS php-base

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    sqlite \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_sqlite zip gd mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Copy application files
COPY . .

# Copy built assets from node-builder
COPY --from=node-builder /app/public/build ./public/build

# Create .env if not exists (Render.com akan override ini)
RUN if [ ! -f .env ]; then cp .env.example .env 2>/dev/null || touch .env; fi

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copy nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Copy supervisor configuration
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Create startup script
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'php artisan config:cache || true' >> /start.sh && \
    echo 'php artisan route:cache || true' >> /start.sh && \
    echo 'php artisan view:cache || true' >> /start.sh && \
    echo 'exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' >> /start.sh && \
    chmod +x /start.sh

# Expose port
EXPOSE 8000

# Start supervisor
CMD ["/start.sh"]

