# --- Base stage for installation of dependencies using Composer ---
FROM composer:2.2.25 AS dependencies_base
WORKDIR /app
COPY composer.json composer.lock ./

# --- Installation of dependencies for development ---
FROM dependencies_base AS dev_dependencies
RUN composer install --ignore-platform-reqs

# --- Installation of dependencies for production ---
FROM dependencies_base AS prod_dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

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
COPY --from=dev_dependencies /app/vendor /var/www/html/vendor

# Source code will be a mounted volume, so no need to copy it here.

RUN chown -R www-data:www-data /var/www/html

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
