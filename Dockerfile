FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    && docker-php-ext-install \
       intl \
       mbstring \
       zip \
       pdo \
       pdo_mysql \
       mysqli

# Enable Apache mod_rewrite and headers
RUN a2enmod rewrite \
    && a2enmod headers

# Copy project files into the container
COPY app /var/www/html/app
COPY public /var/www/html/public
COPY vendor /var/www/html/vendor
COPY writable /var/www/html/writable
COPY LICENSE spark preload.php builds /var/www/html/

# Adjust ownership so Apache can access everything
RUN chown -R www-data:www-data /var/www/html

RUN echo 'alias ll="ls -la"' >> ~/.bashrc

# Expose port 80
EXPOSE 8080

# Start Apache in the foreground
CMD ["apache2-foreground"]
