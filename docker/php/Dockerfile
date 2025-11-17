FROM php:8.2-apache

# Install dependencies for Composer and MongoDB
RUN apt-get update && apt-get install -y unzip git curl libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html
