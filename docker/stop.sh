#!/bin/bash

if docker compose version >/dev/null 2>&1; then
    sudo docker compose -f docker/docker-compose.yml stop
else
    sudo docker-compose -f docker/docker-compose.yml stop
fi
