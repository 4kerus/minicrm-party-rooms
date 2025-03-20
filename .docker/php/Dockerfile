FROM php:8.4-fpm

# Set working directory
WORKDIR /app/

# Set environment variables
ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

# Install system dependencies and clear cache
RUN apt -y update \
    && apt install -y \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxml2-dev \
        libgmp-dev \
        libzip-dev \
        zip \
        unzip \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) \
    iconv \
    gd \
    pdo_mysql \
    soap \
    bcmath \
    gmp \
    intl \
    opcache \
    zip \
    exif

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy PHP config
COPY php.ini /usr/local/etc/php/conf.d/zz-custom.ini

# Expose port 9000
EXPOSE 9000