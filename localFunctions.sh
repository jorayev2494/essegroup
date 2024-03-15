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

function migrate() {
    CONNECTION=$1
    COMMAND=$2

    # if [[ $COMMAND == 'migrate' ]]; then
        MIG_COMMAND=$COMMAND;
    # fi

#    if [[ ]]; then
#    if
#
#    if [[ -z $COMMAND ]]; then
#        MIG_COMMAND='-h';
#    fi

    docker compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli bash -c "ENTITY=${CONNECTION} php ./vendor/bin/doctrine-migrations ${MIG_COMMAND}"
}

function bash()
{
    docker compose --file $SERVER_COMPOSE_FILE_PATH run --rm php-cli bash
}
