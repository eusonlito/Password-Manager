#!/bin/bash

# some internal helper variables
IS_DATABASE_INITIALIZED=false
INSTALL_DIR="/var/www/passwordmanager"


function check_db_init {
    db_rc=0
    table_num=""
    while [ -z "$table_num" ] && [ "$db_rc" -eq "0" ]; do    
        echo "Try to check DB state ..."
        table_num=$(echo "SELECT COUNT(*) FROM information_schema.tables WHERE TABLE_SCHEMA ='passwordmanager';" |  mysql -h $DB_HOST -u $DB_USERNAME --password="$DB_PASSWORD" $DB_DATABASE 2>/dev/null | tail -n 1)
        db_rc=$?
        if [ ! -z "$table_num" ] && [ "$db_rc" -eq "0" ]; then
            break
        fi
        echo "Could not connect to DB server. Try again in 1 second."
        sleep 1
    done
    if [ ! -z "$table_num" ]; then
        echo "Found $table_num table(s) in database."
    fi

    if [ ! -z "$table_num" ] && [ "$table_num" -ne "0" ]; then
        echo "Skip database initialization."
        IS_DATABASE_INITIALIZED=true        
    fi
}


function run_init {
    echo "Run DB initialization"
    php artisan migrate --force
    php artisan db:seed --class=Database\\Seeders\\Database
    php artisan user:create --email=$ADMIN_MAIL --name=$ADMIN_USER --password=$ADMIN_PASSWORD --admin
}


function run_webserver {
    chown -R www-data storage/
    chown -R www-data public/storage/
    php-fpm -D
    nginx -g 'daemon off;'
}


cd "$INSTALL_DIR"
composer artisan-cache

check_db_init
if [ "$IS_DATABASE_INITIALIZED" = "false" ]; then
    run_init
fi

run_webserver
