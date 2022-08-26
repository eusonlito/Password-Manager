#!/bin/bash

# some internal helper variables
IS_DATABASE_INITIALIZED=false
INSTALL_DIR="/var/www/passwordmanager"
ENV_FILE="$INSTALL_DIR/.env" 

# database variables
DB_HOST="${DB_HOST:-localhost}"
DB_USER="${DB_USER:-passwordmanager}"
DB_PASSWORD="${DB_PASSWORD:-passwordmanager}"
DB_DATABASE="${DB_DATABASE:-passwordmanager}"
DB_LOG=${DB_LOG:-false}
DB_CONNECTION="${DB_CONNECTION:-mysql}"

# OpenLDAP variables
LDAP_ENABLED=${LDAP_ENABLED:-false}
LDAP_CONNECTION="${LDAP_CONNECTION:-default}"
LDAP_HOST="${LDAP_HOST:-localhost}"
LDAP_USERNAME="${LDAP_USERNAME:-cn=ldap-ro,dc=example,dc=com}"
LDAP_PASSWORD="${LDAP_PASSWORD:-secret1234}"
LDAP_PORT=${LDAP_PORT:-389}
LDAP_BASE_DN="${LDAP_BASE_DN:-dc=example,dc=com}"
LDAP_TIMEOUT=${LDAP_TIMEOUT:-5}
LDAP_SSL=${LDAP_SSL:-false}
LDAP_TLS=${LDAP_TLS:-false}
LDAP_LOGGING=${LDAP_LOGGING:-false}
LDAP_NAME_FIELD="${LDAP_NAME_FIELD:-cn}"
LDAP_MAIL_FIELD="${LDAP_MAIL_FIELD:-mail}"


# admin account variables
ADMIN_MAIL="${ADMIN_MAIL:-admin@foobar.org}"
ADMIN_USER="${ADMIN_USER:-admin}"
ADMIN_PASSWORD="${ADMIN_PASSWORD:-admin123}"


function check_db_init {
    db_rc=0
    table_num=""
    while [ -z "$table_num" ] && [ "$db_rc" -eq "0" ]; do    
        echo "Try to check DB state ..."
        table_num=$(echo "SELECT COUNT(*) FROM information_schema.tables WHERE TABLE_SCHEMA ='passwordmanager';" |  mysql -h $DB_HOST -u $DB_USER --password="$DB_PASSWORD" $DB_DATABASE 2>/dev/null | tail -n 1)
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
    composer artisan-cache
    php artisan migrate --force
    php artisan db:seed --class=Database\\Seeders\\Database
    php artisan user:create --email=$ADMIN_MAIL --name=$ADMIN_USER --password=$ADMIN_PASSWORD --admin
}


function run_webserver {
    chown -R www-data storage/logs/
    chown -R www-data public/storage/
    php-fpm -D
    nginx -g 'daemon off;'
}


function update_env {
    echo "Update env file $ENV_FILE"

    # set DB settings
    echo "DB_CONNECTION=$DB_CONNECTION"                 >> $ENV_FILE
    echo "DB_HOST=$DB_HOST"                             >> $ENV_FILE
    echo "DB_DATABASE=$DB_DATABASE"                     >> $ENV_FILE
    echo "DB_USERNAME=$DB_USER"                         >> $ENV_FILE
    echo "DB_PASSWORD=$DB_PASSWORD"                     >> $ENV_FILE
    echo "DB_LOG=$DB_LOG"                               >> $ENV_FILE

    # set LDAP setttings
    if [ "$LDAP_ENABLED" = "true" ]; then
        echo "LDAP_ENABLED=$LDAP_ENABLED"               >> $ENV_FILE
        echo "LDAP_CONNECTION=$LDAP_CONNECTION"         >> $ENV_FILE
        echo "LDAP_HOST=$LDAP_HOST"                     >> $ENV_FILE
        echo "LDAP_USERNAME=$LDAP_USERNAME"             >> $ENV_FILE
        echo "LDAP_PASSWORD=$LDAP_PASSWORD"             >> $ENV_FILE
        echo "LDAP_PORT=$LDAP_PORT"                     >> $ENV_FILE
        echo "LDAP_BASE_DN=$LDAP_BASE_DN"               >> $ENV_FILE
        echo "LDAP_TIMEOUT=$LDAP_TIMEOUT"               >> $ENV_FILE
        echo "LDAP_SSL=$LDAP_SSL"                       >> $ENV_FILE
        echo "LDAP_TLS=$LDAP_TLS"                       >> $ENV_FILE
        echo "LDAP_LOGGING=$LDAP_LOGGING"               >> $ENV_FILE
        echo "LDAP_NAME_FIELD=$LDAP_NAME_FIELD"         >> $ENV_FILE
        echo "LDAP_MAIL_FIELD=$LDAP_MAIL_FIELD"         >> $ENV_FILE
    fi
}


cd "$INSTALL_DIR"

update_env
composer artisan-cache

check_db_init
if [ "$IS_DATABASE_INITIALIZED" = "false" ]; then
    run_init
fi

run_webserver
