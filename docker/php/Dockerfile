FROM php:8.5-fpm-bookworm

ENV DEBIAN_FRONTEND=noninteractive

# --------------------------------------------------
# System dependencies
# --------------------------------------------------

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*


# --------------------------------------------------
# PostgreSQL extensions
# --------------------------------------------------

RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql


# --------------------------------------------------
# Laravel PHP extensions
# --------------------------------------------------

RUN docker-php-ext-install \
    mbstring \
    bcmath \
    exif \
    pcntl


# --------------------------------------------------
# Intl
# --------------------------------------------------

RUN docker-php-ext-install intl


# --------------------------------------------------
# ZIP
# --------------------------------------------------

RUN docker-php-ext-install zip


# --------------------------------------------------
# GD
# --------------------------------------------------

RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install gd


# --------------------------------------------------
# OPcache
# --------------------------------------------------

RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.enable_cli=1'; \
        echo 'opcache.memory_consumption=256'; \
        echo 'opcache.interned_strings_buffer=16'; \
        echo 'opcache.max_accelerated_files=20000'; \
        echo 'opcache.validate_timestamps=1'; \
        echo 'opcache.revalidate_freq=2'; \
    } > /usr/local/etc/php/conf.d/opcache.ini


# --------------------------------------------------
# Redis
# --------------------------------------------------

RUN pecl install redis \
    && docker-php-ext-enable redis


# --------------------------------------------------
# Composer
# --------------------------------------------------

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# --------------------------------------------------
# Application
# --------------------------------------------------

WORKDIR /var/www/html

COPY . .


# --------------------------------------------------
# Composer dependencies
# --------------------------------------------------

RUN composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader


# --------------------------------------------------
# Laravel permissions
# --------------------------------------------------

RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache


USER www-data

EXPOSE 9000

CMD ["php-fpm"]