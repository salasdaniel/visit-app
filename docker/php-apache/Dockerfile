FROM php:8.3-apache

# Install system dependencies and PHP extensions
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    pgsql \
    gd \
    zip \
  && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod headers rewrite mime

# Configure proper MIME types
RUN echo "AddType text/css .css" >> /etc/apache2/apache2.conf \
  && echo "AddType application/javascript .js" >> /etc/apache2/apache2.conf \
  && echo "AddType image/png .png" >> /etc/apache2/apache2.conf \
  && echo "AddType image/jpeg .jpg .jpeg" >> /etc/apache2/apache2.conf \
  && echo "AddType image/gif .gif" >> /etc/apache2/apache2.conf \
  && echo "AddType image/svg+xml .svg" >> /etc/apache2/apache2.conf

# Copy VirtualHost configuration
COPY docker/php-apache/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
  && chmod -R 755 /var/www/html
