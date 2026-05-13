FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip \
    libzip-dev \
    libmagickwand-dev \
    imagemagick \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# GD + ZIP + MYSQL
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql zip

# Imagick
RUN pecl install imagick && docker-php-ext-enable imagick

WORKDIR /app

COPY . .

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# IMPORTANT: biar tidak error root
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-dev --optimize-autoloader

RUN php artisan storage:link || true
RUN chmod -R 775 storage bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=$PORT