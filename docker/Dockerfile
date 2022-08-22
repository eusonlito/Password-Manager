FROM php:8.1.0-fpm-buster

# Install basic dependencies
RUN apt-get update && apt-get install -y git nginx unzip mariadb-client libmagickwand-dev
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN pecl install imagick
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable imagick

# Copy code from parent directory
COPY ./ /var/www/passwordmanager
WORKDIR /var/www/passwordmanager 
#RUN rm -rf docker \
#  .git \
#  .gitignore \
#  .gitattributes \
#  .env.example

# Install project dependencies
RUN composer install --no-scripts --no-dev && composer install --no-dev --optimize-autoloader --classmap-authoritative --ansi
RUN chown -R www-data /var/www/passwordmanager

COPY docker/env .env
COPY docker/entrypoint.sh /root/entrypoint.sh
COPY docker/default /etc/nginx/sites-available/default
CMD /root/entrypoint.sh