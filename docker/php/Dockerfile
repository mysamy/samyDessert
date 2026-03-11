FROM php:8.3-fpm

# Extensions PHP requises par Symfony
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libicu-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl

# Composer (gestionnaire de dépendances PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
