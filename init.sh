echo "LEVANTANDO CONTENEDORES DE (DOCKER CON LARAVEL API)"
docker compose up -d --build

docker compose exec -T backend_laravel composer install
docker compose exec -T backend_laravel php artisan key:generate
docker compose exec -T backend_laravel php artisan optimize
docker compose exec -T backend_laravel php artisan migrate:fresh
docker compose exec -T backend_laravel php artisan db:seed

echo "La APP esta en http://localhost:80"

