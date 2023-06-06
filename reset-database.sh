docker compose exec php bin/console d:d:d --force
docker compose exec php bin/console d:d:c
docker compose exec php bin/console m:mig 
docker compose exec php bin/console d:m:m
docker compose exec php bin/console d:s:u --force
docker compose exec php bin/console d:f:l --no-interaction