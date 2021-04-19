.DEFAULT_GOAL:=help
.DEFAULT_GOAL:=help
.DOCKER_COMPOSE := docker-compose -f docker-compose.yml -f docker-compose-dev.yml
.DOCKER_RUN_PHP := $(.DOCKER_COMPOSE) run --rm php
.RUN=

ifneq ($(AM_I_INSIDE_DOCKER),true)
    .RUN := $(.DOCKER_RUN_PHP)
endif

# -- Default -- #
.PHONY: setup destroy start stop restart test
setup: setup dependencies ## Setup the Project
destroy: down-with-volumes ## Destroy the project
start: up ## Start the application
stop: down ## Stop the docker containers
restart: down up ## Restart the docker containers
generate-payroll: generate-payroll ## Start a shell in docker container
test: unittest functionaltest ## Run the test suite
qa: php-cs-fixer phpstan ## Run the quality assurance suite
# -- // Default -- #

.PHONY: setup
setup:
	$(.DOCKER_COMPOSE) pull

.PHONY: up
up:
	$(.DOCKER_COMPOSE) up -d --build

.PHONY: shell
generate-payroll:
	$(.RUN) bin/generate-payroll

.PHONY: down
down:
	$(.DOCKER_COMPOSE) down

.PHONY: down-with-volumes
down-with-volumes:
	$(.DOCKER_COMPOSE) down --remove-orphans --volumes

dependencies:
	$(.RUN) composer install --no-interaction --no-scripts --ansi

unittest:
	$(.RUN) vendor/bin/phpunit --configuration phpunit.xml.dist --stop-on-failure --testdox --testsuit unit

functionaltest:
#	$(.RUN) vendor/bin/phpunit --configuration phpunit.xml.dist --stop-on-failure --testdox --testsuit functional

phpstan:
	$(.RUN) ./vendor/bin/phpstan analyse --memory-limit=2m -l max src/

php-cs-fixer:
	$(.RUN) ./vendor/bin/php-cs-fixer fix --allow-risky=yes

# Based on https://suva.sh/posts/well-documented-makefiles/
help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)
