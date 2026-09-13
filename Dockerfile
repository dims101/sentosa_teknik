FROM php:7.4.33-fpm-bullseye

RUN echo "Acquire::Retries \"5\";" > /etc/apt/apt.conf.d/80-retries \
    && echo "Acquire::http::Timeout \"120\";" >> /etc/apt/apt.conf.d/80-retries \
    && apt-get update \
    && apt-get install -y --no-install-recommends --fix-missing \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev libonig-dev unzip zip libzip-dev git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Atur timeout Composer agar tidak gampang putus
ENV COMPOSER_PROCESS_TIMEOUT=3600
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www

# Salin definisi paket terlebih dahulu untuk Docker caching
COPY composer.json composer.lock ./

# Install dependensi dengan preferensi dist & parallel download
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --prefer-dist

# Salin seluruh kodingan aplikasi
COPY . .

# Generate autoloader teroptimasi
RUN composer dump-autoload --optimize --no-dev

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
