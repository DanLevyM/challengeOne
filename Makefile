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