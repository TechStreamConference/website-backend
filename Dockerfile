# --- Installation of dependencies for production ---
FROM composer:2.2.25 AS prod_dependencies
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

FROM composer:2.2.25 AS dev_dependencies
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --ignore-platform-reqs

# --- Base image for the final stages ---
FROM php:8.2-apache AS base
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install \
       intl \
       mbstring \
       zip \
       pdo \
       pdo_mysql \
       mysqli \
       gd
RUN a2enmod rewrite && a2enmod headers

RUN echo 'alias ll="ls -la"' >> ~/.bashrc

# --- Development stage ---
FROM base AS dev
WORKDIR /var/www/html
COPY --from=dev_dependencies /app/vendor/ /vendor.bak/
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
# Source code will be a mounted volume, so no need to copy it here.
EXPOSE 80
CMD ["apache2-foreground"]

### --- Production stage ---
FROM base AS prod

COPY --from=prod_dependencies /app/vendor /var/www/html/vendor

COPY app /var/www/html/app
COPY public /var/www/html/public
COPY writable /var/www/html/writable
COPY LICENSE spark preload.php builds /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
