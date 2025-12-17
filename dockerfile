# Use a lightweight Alpine-based PHP-FPM image
FROM php:8.1-fpm-alpine

# Set the working directory inside the container
WORKDIR /var/www

# Install necessary dependencies
RUN apk add --no-cache \
    git \
    curl \
    unzip \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    libwebp-dev\
    postgresql-dev \
    bash \
    nodejs npm \
    tzdata

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring zip pdo pdo_pgsql opcache

# Install and enable Xdebug for debugging
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist

# Install frontend dependencies and build assets
RUN npm install && npm run build

# Set proper permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Define volume to persist data (hot reloading enabled)
VOLUME ["/var/www"]

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
