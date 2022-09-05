FROM php:8.0-fpm-buster

# Install basic dependencies
RUN apt-get update && apt-get install -y \
  nginx \
  unzip \
  mariadb-client \
  libmagickwand-dev \
  libldb-dev \
  libldap2-dev \
  vim

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN pecl install imagick
RUN docker-php-ext-install mysqli pdo pdo_mysql ldap
RUN docker-php-ext-enable imagick

# Copy code from repo root directory
COPY ./ /var/www/passwordmanager
WORKDIR /var/www/passwordmanager
RUN chown -R www-data resources/ 

# Install project dependencies
RUN composer install --no-scripts --no-dev --classmap-authoritative --ansi --optimize-autoloader

COPY docker/entrypoint.sh /root/entrypoint.sh
COPY docker/etc/nginx/sites-available/default /etc/nginx/sites-available/default
