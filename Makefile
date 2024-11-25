.PHONY: up

pull :
	docker-compose pull

composer_install :
	docker-compose exec php composer install

up :  pull docker_up composer_install

docker_up :
	docker-compose up -d

down :
	docker-compose down

shell :
	docker-compose exec php /bin/bash

tail :
	docker-compose logs -f php

