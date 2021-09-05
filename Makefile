#!/bin/bash

help: # Show help
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

build: ## Build and run
	docker-compose up -d --build
run: ## Up docker containers
	docker-compose up -d
composer-install: ## Run composer install
	docker-compose exec php composer install --no-scripts --no-interaction --optimize-autoloader
code-analyse: ## Analyse code
	docker-compose exec php vendor/bin/phpstan analyse -l 8 src tests
tests: ## Run all tests
	docker-compose exec -T php bin/phpunit
get-cities-forecast: ## Get cities from Musement's API and get forecast
	docker-compose exec php bin/console musement:get-cities-forecast