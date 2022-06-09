HOST_GROUP_ID = $(shell id -g)
HOST_USER = $USER
HOST_UID = $(shell id -u)

export HOST_UID
export HOST_USER
export HOST_GROUP_ID

DOCKER_COMPOSE_DEV = docker-compose -f docker-compose.yml -f docker-compose.dev.yml
DOCKER_COMPOSE_PROD = docker-compose -f docker-compose.yml -f docker-compose.prod.yml --env=.env.prod.local


help: ## Display available commands
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

# =====================================================================
# Install =============================================================
# =====================================================================

install: ## Install docker stack, assets and vendors
	$(DOCKER_COMPOSE_DEV) pull
	$(DOCKER_COMPOSE_DEV) build
	$(MAKE) composer-install
	$(MAKE) assets-install
	$(MAKE) db-migrate
	$(MAKE) js-deps-install

db-migrate: ## Migrate database
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php bin/console doctrine:migration:migrate --no-interaction'

db-migrate-prev: ## Down previous migration in database
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php bin/console doctrine:migration:migrate prev'

db-generate: ## generate migration file
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php bin/console doctrine:migration:generate'

db-diff: ## generate migration file based on diff
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php bin/console doctrine:migration:diff'

composer-install: ## Install composer vendor
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php -d memory_limit=4G bin/composer install'

js-deps-install: ## Install javascript modules
	$(DOCKER_COMPOSE_DEV) run --rm yarn bash -ci 'yarn install'

assets-install: ## Install composer vendor and setup assets
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php bin/console assets:install'

grumphp-install: ## Install javascript modules
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php ./vendor/bin/grumphp git:init'

fixtures-install: ## Install fixtures
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php bin/console doctrine:database:drop --force'
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php bin/console doctrine:database:create'
	$(MAKE) db-migrate
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci 'php -d memory_limit=4G bin/console doctrine:fixtures:load --append'

# =====================================================================
# Development =========================================================
# =====================================================================

start: ## Start all the stack (you can access the project on localhost:8080 after that)
	@-docker network create eunnow_stack
	$(DOCKER_COMPOSE_DEV) up -d
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci './clear-cache.sh'
	@echo "Now you can access http://localhost:8088"

stop: ## Stop all the containers that belongs to the project
	@-docker network disconnect eunnow_stack $$(docker ps --filter "name=eunnow_php_*" -q)
	$(DOCKER_COMPOSE_DEV) down

connect: ## Connect on a remote bash terminal on the php container
	$(DOCKER_COMPOSE_DEV) exec php bash

log: ## Show logs from php container
	$(DOCKER_COMPOSE_DEV) logs -f php

status: ## Check container status
	$(DOCKER_COMPOSE_DEV) ps

yarn-connect: ## Connect on a remove bash terminal on the yarn container
	$(DOCKER_COMPOSE_DEV) run yarn bash

yarn-upgrade: ## Upgrade yarn dependencies
	@read -p "Enter vendor name: (empty to update all)" package; \
	$(DOCKER_COMPOSE_DEV) run --rm yarn bash -ci 'yarn upgrade $$package'

yarn-add: ## Add yarn dependencies
	@read -p "Enter package name: " package; \
	$(DOCKER_COMPOSE_DEV) run --rm yarn bash -ci 'yarn add $$package'

build-assets: ## Build assets (minimized) for production
	$(DOCKER_COMPOSE_DEV) run --rm yarn bash -ci 'yarn encore production'

build-assets-watch: ## Build assets for dev in watch mode
	$(DOCKER_COMPOSE_DEV) run --rm yarn bash -ci 'yarn encore dev --watch'

composer-require: ## Add composer dependencies
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci "php -d memory_limit=-1 bin/composer require"

composer-update: ## Update composer dependencies
	@read -p "Enter vendor name: (empty to update all)" vendor; \
	$(DOCKER_COMPOSE_DEV) run --rm php bash -ci "php -d memory_limit=-1 bin/composer update $$vendor"

# =====================================================================
# Production  =========================================================
# =====================================================================

deploy_prod: ## Deploy config
	git pull
	$(DOCKER_COMPOSE_PROD) pull
	$(DOCKER_COMPOSE_PROD) build
	$(DOCKER_COMPOSE_PROD) run --rm php bash -ci 'php bin/composer install --no-dev --optimize-autoloader -n'
	$(DOCKER_COMPOSE_PROD) run --rm php bash -ci 'php bin/console assets:install -n'
	$(DOCKER_COMPOSE_PROD) run --rm php bash -ci 'php bin/console doctrine:migration:migrate --no-interaction'
	$(MAKE) deploy_prod_start
	$(MAKE) deploy_prod_status

deploy_prod_stop:
	$(DOCKER_COMPOSE_PROD) down

deploy_prod_start:
	$(DOCKER_COMPOSE_PROD) up -d
	$(DOCKER_COMPOSE_PROD) run --rm php bash -ci './clear-cache.sh'

deploy_prod_status:
	$(DOCKER_COMPOSE_PROD) ps

deploy_prod_connect:
	$(DOCKER_COMPOSE_PROD) exec php bash

default: help
