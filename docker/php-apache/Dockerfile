# ---- Stage 1: PHP CLI con gd + Composer ----
FROM php:8.3-cli AS vendor
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j"$(nproc)" gd zip; \
    rm -rf /var/lib/apt/lists/*

# instalar binario de composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-ansi --no-progress

COPY . .
RUN composer dump-autoload --no-dev --optimize --classmap-authoritative

# ---- Stage 2: PHP + Apache (runtime) ----
FROM php:8.3-apache
ENV DEBIAN_FRONTEND=noninteractive
RUN set -eux; \
    apt-get update; \
    buildDeps="$PHPIZE_DEPS libpq-dev libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip"; \
    apt-get install -y --no-install-recommends $buildDeps; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j"$(nproc)" pdo pdo_pgsql pgsql gd zip; \
    a2enmod headers rewrite mime; \
    apt-get purge -y --auto-remove $buildDeps; \
    rm -rf /var/lib/apt/lists/*

COPY docker/php-apache/vhost.conf /etc/apache2/sites-available/000-default.conf
WORKDIR /var/www/html
COPY --chown=www-data:www-data . /var/www/html
COPY --from=vendor --chown=www-data:www-data /app/vendor /var/www/html/vendor
