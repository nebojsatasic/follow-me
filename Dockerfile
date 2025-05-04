FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    freetype-dev \
    imagemagick \
    imagemagick-dev \
    sqlite \
    sqlite-dev \
    icu-dev \
    zlib-dev \
    libzip-dev \
    oniguruma \
    libxml2 \
    libtool \
    autoconf \
    g++ \
    make \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install \
    gd \
        pdo \
        pdo_sqlite \
        zip \
        opcache \
        intl \
        bcmath \
        pcntl \
&& apk del \
    imagemagick-dev \
    sqlite-dev \
    libtool \
    autoconf \
    g++ \
    make

# Copy custom_php.ini
COPY ./php/custom_php.ini /usr/local/etc/php/conf.d/zz-custom_php.ini

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm"]
