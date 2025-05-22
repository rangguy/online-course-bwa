# Use the official PHP 8.3 FPM image
FROM php:8.3.12-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www/html

# Copy .env.example to .env
RUN cp .env.example .env

# Set permissions for storage and cache directories
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html

# Switch to the www-data user
USER www-data

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate application key
RUN php artisan key:generate

# Expose port 9000
EXPOSE 9000

# Command to start php-fpm server
CMD ["php-fpm"]
