.PHONY: up

up :  pull docker_up composer_install

pull :
	docker-compose pull

composer_install :
	docker-compose exec php composer install

docker_up :
	docker-compose up -d

down :
	docker-compose down

shell :
	docker-compose exec php /bin/bash

tail :
	docker-compose logs -f php

test : test-unit test-e2e

test-unit :
	docker-compose exec php vendor/bin/phpunit tests/Unit

test-e2e :
	docker-compose exec php vendor/bin/phpunit tests/E2e