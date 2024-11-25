.PHONY: up

pull :
	docker-compose pull

composer_install :
	docker-compose exec php composer install

docker_up :
	docker-compose up -d

up :  pull docker_up composer_install

down :
	docker-compose down

shell :
	docker-compose exec php /bin/bash

tail :
	docker-compose logs -f php

