FROM php:8.3-fpm

# Extensions PHP requises par Symfony
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libicu-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl opcache

# Mémoire PHP : 512M pour Symfony en dev (cache Twig, requêtes Doctrine, profiler)
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory.ini

# OPcache : évite de reparser les fichiers PHP à chaque requête
RUN echo "opcache.enable=1\n\
opcache.memory_consumption=256\n\
opcache.max_accelerated_files=20000\n\
opcache.revalidate_freq=0\n\
opcache.validate_timestamps=1" > /usr/local/etc/php/conf.d/opcache.ini

# Composer (gestionnaire de dépendances PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html