.PHONY: up

up :  pull docker_up composer_install

pull :
	docker-compose pull

docker_up :
	docker-compose up -d

composer_install :
	docker-compose exec php composer install

down :
	docker-compose down

shell :
	docker-compose exec php /bin/bash

tail :
	docker-compose logs -f php

rediscli:
	docker exec -it redis-container redis-cli

test : test-unit test-e2e

test-unit :
	docker-compose exec php vendor/bin/phpunit tests/Unit

test-e2e :
	docker-compose exec php vendor/bin/phpunit tests/E2e