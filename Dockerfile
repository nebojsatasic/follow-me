# Use PHP 8.2 FPM Alpine
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www
#RUN apk add --no-cache autoconf bash curl gcc g++ make libtool re2c
# Install required dependencies
#RUN apk add --no-cache \
RUN apk add --no-cache autoconf bash curl gcc g++ make libtool re2c \
    php-bcmath \
    php-mbstring \
    php-pdo_mysql \
    php-zip \
    php-openssl \
    php-tokenizer \
    php-xml \
    php-curl \
    php-session \
    php-fileinfo \
    imagemagick \
    imagemagick-dev \
    php-gd \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# Install Composer
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel project files
COPY ./src .

# Set correct ownership for Laravel project
# Set permissions: 755 for directories, 644 for files
#RUN chown -R nginx:nginx /var/www \
#    && find /var/www -type d -exec chmod 755 + \
#    && find /var/www -type f -exec chmod 644 +

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
