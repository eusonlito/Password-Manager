FROM php:8.0-fpm-buster

RUN apt-get update -y && apt-get upgrade -y

RUN apt install -y git libbz2-dev libicu-dev libldb-dev libmagickwand-dev \
    libxslt-dev libzip-dev mariadb-client nginx unzip vim

RUN pecl install imagick

RUN docker-php-ext-install bcmath bz2 intl opcache pdo_mysql xsl zip
RUN docker-php-ext-enable imagick

WORKDIR /var/www/passwordmanager

COPY ./ /var/www/passwordmanager

RUN cp -n ./docker/.env .

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN composer install --no-scripts --no-dev
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative

CMD ["./docker/init.sh"]
