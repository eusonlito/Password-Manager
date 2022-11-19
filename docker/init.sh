#!/bin/bash

if [ "$APP_KEY" == "base64:YDd7vBg1pOO9e44ROzZT9MUkfB4p6aKBswlyuNJrxQo=" ]; then
    echo -e "\e[41m WARNING: YOU ARE USING THE DEFAULT APP_KEY VALUE. PLEASE UPDATE THIS KEY ON FILE docker/.env BEFORE ADD YOUR FIRST APP \e[0m"
fi

composer artisan-cache

php artisan migrate --force
php artisan db:seed --force --class=Database\\Seeders\\Database

php artisan serve --host=0.0.0.0 --port=80
