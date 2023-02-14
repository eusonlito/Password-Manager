FROM php:8.1

RUN apt-get update -y && apt-get upgrade -y

RUN apt install -yqq --no-install-recommends \
    cron default-mysql-client \
    libbz2-dev libicu-dev libldb-dev libonig-dev \
    libmagickwand-dev libxslt-dev libzip-dev procps unzip

RUN rm -rf /var/lib/apt/lists/*

RUN apt clean && apt autoclean && apt autoremove --assume-yes

RUN pecl install imagick

RUN docker-php-ext-install bcmath bz2 intl mbstring opcache pdo_mysql xsl zip
RUN docker-php-ext-enable imagick

COPY ./docker/php.ini /usr/local/etc/php/

COPY ./docker/crontab /etc/cron.d/crontab

WORKDIR /var/www/passwordmanager

COPY ./ /var/www/passwordmanager

RUN cp -n ./docker/.env .

COPY --from=composer:2.5 /usr/bin/composer /usr/local/bin/composer

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --classmap-authoritative

CMD ["./docker/init.sh"]
