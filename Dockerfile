# --- Stage 1: Build the application ---
FROM composer:2.2.25 AS builder

WORKDIR /app

# Copy the composer files
COPY composer.json composer.lock ./

# Install the dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs # Creates the vendor directory

# --- Stage 2: Create the final image ---
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libpng-dev \
    && docker-php-ext-install \
       intl \
       mbstring \
       zip \
       pdo \
       pdo_mysql \
       mysqli \
       gd

# Enable Apache mod_rewrite and headers
RUN a2enmod rewrite \
    && a2enmod headers

# Copy the vendor directory from the builder stage
COPY --from=builder /app/vendor /var/www/html/vendor

# Copy project files into the container
COPY app /var/www/html/app
COPY public /var/www/html/public
COPY writable /var/www/html/writable
COPY LICENSE spark preload.php builds /var/www/html/

# Adjust ownership so Apache can access everything
RUN chown -R www-data:www-data /var/www/html

RUN echo 'alias ll="ls -la"' >> ~/.bashrc

EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
