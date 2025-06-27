FROM php:8.2-fpm

WORKDIR /var/www/html

COPY composer.lock composer.json /var/www/html/

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    vim \
    git \
    curl \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html

# RUN php artisan migrate

EXPOSE 9000

CMD ["php-fpm"]