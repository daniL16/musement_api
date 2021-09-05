#!/bin/bash

help: # Show help
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

build: ## Build and run
	docker-compose up -d --build
run: ## Run
	docker-compose up -d
composer-install: ## Run composer install
	docker-compose exec php composer install --no-scripts --no-interaction --optimize-autoloader
code-analyse: ## Analyse code
	docker-compose exec php vendor/bin/phpstan analyse src tests
tests: ## Run all tests
	docker-compose exec -T php vendor/bin/phpunit