#!/bin/bash

SERVER_COMPOSE_FILE_PATH=./docker/docker-compose.yml

# Create .env from .env.example
function env() {
    if [ ! -f .env ]; then
        cp .env.example .env
    fi

    if [ ! -f ./docker/.env ]; then
        cp ./docker/.env.example ./docker/.env
    fi
}

function status()
{
    docker compose --file $SERVER_COMPOSE_FILE_PATH ps;
}

function start()
{
    docker compose --file $SERVER_COMPOSE_FILE_PATH up -d --force-recreate --remove-orphans
    status
}

function stop()
{
    docker compose --file $SERVER_COMPOSE_FILE_PATH down --remove-orphans
}

function restart()
{
    stop
    start
}

function pull()
{
    docker compose --file ${SERVER_COMPOSE_FILE_PATH} pull --no-parallel
}

function build() {
	docker compose --file $SERVER_COMPOSE_FILE_PATH build ${@:1}
}

function migrations() {
    ARGS=${@:1};

    if [[ ${@:1} == *"execute --down"* ]]; then
        ARGS="execute --down 'Project\\Domains\\Admin\\Authentication\\Infrastructure\\Repositories\\Doctrine\\Migrations\\$3'"
    fi

    if [[ $1 == "rm" && $2 != -z ]]; then
        docker compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli bash -c "rm './src/Domains/Admin/Authentication/Infrastructure/Repositories/Doctrine/Migrations/$2.php'"
        exit;
    fi

    docker compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli bash -c "ENTITY=admin php ./vendor/bin/doctrine-migrations migrations:$ARGS"
}

function bash()
{
    docker compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli bash
}
