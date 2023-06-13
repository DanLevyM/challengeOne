.PHONY: build start stop db fixtures test

build:
	docker compose build --pull --no-cache

start:
	docker compose up -d

stop:
	docker compose down --remove-orphans

db:
	docker compose exec php bin/console doctrine:schema:update --force

fixtures:
	docker compose exec php bin/console doctrine:fixtures:load 

test:
	docker compose exec php bin/phpunit
	docker compose exec web npm run test

renew:
	docker compose exec php bin/console d:d:d --force
	docker compose exec php bin/console d:d:c
	docker compose exec php bin/console m:mig
	docker compose exec php bin/console d:m:m
	docker compose exec php bin/console d:s:u --force
	docker compose exec php bin/console d:f:l --no-interaction
