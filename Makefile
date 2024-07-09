DOCKER_PATH := ./docker
DOCKER_COMPOSE_FILE := ./docker/docker-compose.yml
DOCKER_COMPOSE_DEV_FILE := ./docker/docker-compose.dev.yml

ps:
	docker compose -f ${DOCKER_COMPOSE_FILE} ps

ps-dev:
	docker compose -f ${DOCKER_COMPOSE_DEV_FILE} ps

up:
	docker compose -f ${DOCKER_COMPOSE_FILE} --env-file ${DOCKER_PATH}/nginx/.env up -d --remove-orphans

up-dev:
	docker compose -f ${DOCKER_COMPOSE_DEV_FILE} up -d --remove-orphans

up-build:
	docker compose -f ${DOCKER_COMPOSE_FILE} up --build -d --remove-orphans

up-dev-build:
	docker compose -f ${DOCKER_COMPOSE_DEV_FILE} up --build -d --remove-orphans

down:
	docker compose -f ${DOCKER_COMPOSE_FILE} down --remove-orphans

down-dev:
	docker compose -f ${DOCKER_COMPOSE_DEV_FILE} down --remove-orphans

build:
	docker compose -f ${DOCKER_COMPOSE_FILE} build

build-dev:
	docker compose -f ${DOCKER_COMPOSE_DEV_FILE} build

bash:
	docker compose -f ${DOCKER_COMPOSE_FILE} run --rm php-cli bash

bash-dev:
	docker compose -f ${DOCKER_COMPOSE_DEV_FILE} run --rm php-cli bash

migration:
	ENTITY=client php ./vendor/bin/doctrine-migrations diff
