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

if [ ! -e .env ]; then
    cp docker/.env.example .env
fi

if [ ! -e docker/docker-compose.yml ]; then
    cp docker/docker-compose.yml.example docker/docker-compose.yml
fi

if docker compose version >/dev/null 2>&1; then
    sudo docker compose -f docker/docker-compose.yml build
else
    sudo docker-compose -f docker/docker-compose.yml build
fi
