FROM php:8.2-fpm

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libmagickwand-dev \
    imagemagick

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Imagick
RUN pecl install imagick && docker-php-ext-enable imagick

# Set working directory
WORKDIR /app

COPY . .

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader

# Laravel permission (penting)
RUN chmod -R 775 storage bootstrap/cache

# Jalankan server
CMD php artisan serve --host=0.0.0.0 --port=$PORT