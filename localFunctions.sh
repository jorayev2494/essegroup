#!/bin/bash

DOCKER_PATH=/docker
# SERVER_COMPOSE_FILE_PATH=./docker/docker-compose.yml
# SERVER_COMPOSE_FILE_PATH=./docker/docker-compose.test.yml

ENV_DIRS=(/ /nginx /php /php_cli /mysql /redis /mailhog)

# https://docs.docker.com/compose/environment-variables/envvars/#compose_env_files
export COMPOSE_PROJECT_NAME=essegroup
export COMPOSE_FILE=./docker/docker-compose.yml
export COMPOSE_ENV_FILES=$PWD$DOCKER_PATH/.env,$PWD$DOCKER_PATH/nginx/.env,$PWD$DOCKER_PATH/php/.env,$PWD$DOCKER_PATH/php_cli/.env,$PWD$DOCKER_PATH/mysql/.env,$PWD$DOCKER_PATH/redis/.env,$PWD$DOCKER_PATH/mailhog/.env

function makeCopyFromEnvFile()
{
    COPY_FROM_ENV=".env"

    if [[ -n "$1" ]]; then
        COPY_FROM_ENV+=".$1"
    else
        COPY_FROM_ENV+=".example"
    fi
}

# Create .env from .env.example
function env()
{
    makeCopyFromEnvFile "$1"

    if [ ! -f .env ]; then
        cp ./$COPY_FROM_ENV ./.env
    fi
}

function dockerEnv()
{
    makeCopyFromEnvFile "$1"

    for dir in ${ENV_DIRS[@]} ; do
        cp ./$DOCKER_PATH/$dir/$COPY_FROM_ENV ./$DOCKER_PATH/$dir/.env
    done

    # if [ ! -f ./docker/.env ]; then
    #     cp ./docker/$COPY_FROM_ENV ./docker/.env
    # fi
}

function status()
{
    docker compose ps
}

function start()
{
    docker compose up -d --force-recreate --remove-orphans
    status
}

function stop()
{
    docker compose down --remove-orphans
}

function restart()
{
    stop
    start
}

function pull()
{
    docker compose pull --no-parallel
}

function build()
{
	docker compose build "${@:1}"
}

function migrations()
{
    ARGS="${@:1}";

    if [[ "${@:1}" == *"execute --down"* ]]; then
        ARGS="execute --down 'Project\\Domains\\Admin\\Authentication\\Infrastructure\\Repositories\\Doctrine\\Migrations\\$3'"
    fi

    if [[ $1 == "rm" && $2 != -z ]]; then
        docker compose run --rm php-cli bash -c "rm './src/Domains/Admin/Authentication/Infrastructure/Repositories/Doctrine/Migrations/$2.php'"
        exit;
    fi

    docker compose run --rm php-cli bash -c "ENTITY=admin php ./vendor/bin/doctrine-migrations migrations:$ARGS"
}

function bash()
{
    docker compose run --rm php-cli bash
}

function artisan()
{
    docker compose run --rm php-cli bash -c "php artisan ${@:1}"
}

function composer()
{
    docker compose run --rm php-cli bash -c "composer ${@:1}"
}
