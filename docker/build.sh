#!/bin/bash

sudo rm -rf bootstrap/cache/*.php

# Upgrade from previous version
if [ ! -f .env ] && [ $(sudo docker ps -aq -f name=^passwordmanager$) != "" ]; then
    echo ""
    echo "Copied .env file from previous version"
    echo ""

    sudo docker cp -q passwordmanager:/var/www/passwordmanager/.env .env

    sudo sed -i 's/DB_HOST=mariadb/DB_HOST=passwordmanager-mariadb/' .env
fi

cp -n docker/.env.example .env
cp -n docker/docker-compose.yml.example docker/docker-compose.yml

sudo docker-compose -f docker/docker-compose.yml build
