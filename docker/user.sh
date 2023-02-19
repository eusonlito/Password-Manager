#!/bin/bash

echo ""
echo "Adding an Admin User to Password Manager"
echo ""

while true; do
    read -p "Email: " email

    if [ "$email" != "" ]; then
        break;
    fi
done

while true; do
    read -p "Name: " name

    if [ "$name" != "" ]; then
        break;
    fi
done

while true; do
    read -p "Password: " password

    if [ "$password" != "" ]; then
        break;
    fi
done

echo ""

sudo docker exec -it passwordmanager-app bash -c "cd /app && su -s /bin/bash -c 'php artisan user:create --email=$email --name=$name --password=$password --admin' www-data"
