composer install --no-dev --optimize-autoloader --classmap-authoritative

php artisan migrate --force
php artisan db:seed --force --class=Database\\Seeders\\Database

php artisan serve --host=0.0.0.0 --port=80
