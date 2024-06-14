PHP_EXEC = \
	docker exec php

build:
	docker compose build
	docker compose up -d
	$(PHP_EXEC) composer install

migrate:
	$(PHP_EXEC) php bin/console doctrine:migrations:migrate

start:
	docker compose up -d

stop:
	docker compose down

unit-test:
	$(PHP_EXEC) ./vendor/bin/phpunit --testsuite=Unit

integration-test:
	$(PHP_EXEC) php bin/console --env=test doctrine:database:create
	$(PHP_EXEC) php bin/console --env=test doctrine:schema:create
	$(PHP_EXEC) ./vendor/bin/phpunit --testsuite=Integration
	$(PHP_EXEC) php bin/console --env=test doctrine:database:drop --force
	
