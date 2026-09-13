FROM php:7.4.33-fpm-bullseye

RUN echo "Acquire::Retries \"5\";" > /etc/apt/apt.conf.d/80-retries \
    && echo "Acquire::http::Timeout \"120\";" >> /etc/apt/apt.conf.d/80-retries \
    && apt-get update \
    && apt-get install -y --no-install-recommends --fix-missing \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libonig-dev unzip zip libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Salin definisi paket terlebih dahulu untuk memanfaatkan Docker Layer Caching
COPY composer.json composer.lock ./

# Install dependensi (di-cache oleh Docker jika composer.json & lock tidak berubah)
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

# Baru salin seluruh kodingan aplikasi
COPY . .

# Generate autoloader teroptimasi (cepat, hanya 1-2 detik)
RUN composer dump-autoload --optimize --no-dev

RUN mkdir -p public/Galleries public/BlogPosts public/Earnings public/Expenses public/Payments public/Types \
    && chown -R www-data:www-data storage bootstrap/cache public \
    && chmod -R 775 storage bootstrap/cache public

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
