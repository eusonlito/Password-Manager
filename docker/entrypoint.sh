#!/bin/bash

# some internal helper variables
IS_DATABASE_INITIALIZED=false
INSTALL_DIR="/var/www/passwordmanager"
ENV_FILE="$INSTALL_DIR/.env" 

# database settings
DB_HOST="${DB_HOST:-localhost}"
DB_USER="${DB_USER:-passwordmanager}"
DB_PASSWORD="${DB_PASSWORD:-passwordmanager}"
DB_DATABASE="${DB_DATABASE:-passwordmanager}"

# admin account configuration
ADMIN_MAIL="${ADMIN_MAIL:-admin@foobar.org}"
ADMIN_USER="${ADMIN_USER:-admin}"
ADMIN_PASSWORD="${ADMIN_PASSWORD:-admin123}"


function check_db_init {
    db_rc=1
    table_num=""
    while [ $db_rc -ne 0 ]; do    
        echo "Try to check DB state ..."
        table_num=$(echo "SELECT COUNT(*) FROM information_schema.tables WHERE TABLE_SCHEMA ='passwordmanager';" |  mysql -h $DB_HOST -u $DB_USER --password="$DB_PASSWORD" $DB_DATABASE 2>/dev/null | tail -n 1)
        db_rc=$?
        if [ ! -z "$table_num" ] && [ "$db_rc" -eq "0" ]; then
            break
        fi
        echo "Could not connect to DB server. Try again in 1 second."
        sleep 1
    done
    if [ ! -z "$table_num" ];
        echo "Found $table_num table(s) in database."
    fi

    if [ ! -z "$table_num" ] && [ "$table_num" -ne "0" ]; then
        echo "Skip database initialization."
        IS_DATABASE_INITIALIZED=true        
    fi
}


function run_init {
    echo "Run DB initialization"
    composer artisan-cache
    php artisan migrate --force
    php artisan db:seed --class=Database\\Seeders\\Database
    php artisan user:create --email=$ADMIN_MAIL --name=$ADMIN_USER --password=$ADMIN_PASSWORD --admin
}


function run_webserver {
    php-fpm -D
    nginx -g 'daemon off;'
}


function update_env {
    echo "Update env file $ENV_FILE"
    echo "DB_HOST=$DB_HOST"         >> $ENV_FILE
    echo "DB_DATABASE=$DB_DATABASE" >> $ENV_FILE
    echo "DB_USERNAME=$DB_USER"     >> $ENV_FILE
    echo "DB_PASSWORD=$DB_PASSWORD" >> $ENV_FILE
}


cd "$INSTALL_DIR"

update_env
composer artisan-cache

check_db_init
if [ "$IS_DATABASE_INITIALIZED" = "false" ]; then
    run_init
fi

run_webserver
