FROM dunglas/frankenphp:1.11.3-php8.3-bookworm

# Extensions PHP requises par Symfony
RUN install-php-extensions pdo pdo_mysql zip intl opcache gd

# Logs PHP vers stderr (visibles dans Railway)
RUN echo "error_log = /dev/stderr\ndisplay_errors = Off\nlog_errors = On\nerror_reporting = E_ALL" \
    > /usr/local/etc/php/conf.d/errors.ini

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Dépendances PHP
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copie du projet
COPY . .

# Assets : installation vendors JS + compilation Tailwind + AssetMapper
RUN APP_ENV=prod php bin/console importmap:install --no-interaction || true
RUN APP_ENV=prod php bin/console tailwind:build --no-interaction || true
RUN APP_ENV=prod php bin/console asset-map:compile --no-interaction || true

# Cache Symfony prod
RUN APP_ENV=prod php bin/console cache:warmup --no-interaction || true

EXPOSE 8080

COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

ENTRYPOINT ["/start.sh"]
