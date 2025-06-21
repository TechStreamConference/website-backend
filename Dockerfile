ARG HOST_UID=1000
ARG HOST_GID=1000

# --- Installation of dependencies for production ---
FROM composer:2.2.25 AS prod_dependencies
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

FROM composer:2.2.25 AS dev_dependencies

ARG HOST_UID
ARG HOST_GID

WORKDIR /app

# Install shadow package to enable user/group creation with specific UID/GID
RUN apk add --no-cache shadow

# Create group and user only if they don't already exist
RUN set -eux; \
    if ! getent group "$HOST_GID" > /dev/null; then \
        groupadd -g "$HOST_GID" appgroup; \
    fi; \
    if ! getent passwd "$HOST_UID" > /dev/null; then \
        useradd -u "$HOST_UID" -g "$HOST_GID" -m appuser; \
    fi

RUN chown -R $HOST_UID:$HOST_GID /app

USER ${HOST_UID}:${HOST_GID}

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

# --- Development stage ---
FROM base AS dev

ARG HOST_UID
ARG HOST_GID

WORKDIR /var/www/html

# Create user and group matching the host's
# Avoid conflicts if the UID/GID already exist
RUN getent group $HOST_GID || groupadd -g $HOST_GID appgroup && \
    getent passwd $HOST_UID || useradd -u $HOST_UID -g $HOST_GID -m appuser
RUN chown -R $HOST_UID:$HOST_GID /var/www/html

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
