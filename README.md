docker compose pull

docker compose build

docker compose run --rm php composer create-project laravel/laravel laravel --prefer-dist mv README.md README-docker.md -mv -f ./laravel/* ./laravel/.* ./ -rm -rf ./laravel

Edit .env

docker compose up -d

docker compose run --rm node npm install

docker compose exec php php artisan key:generate

docker-compose run --rm php php artisan storage:link

docker compose exec php php artisan migrate

docker compose exec php chmod -R 775 storage bootstrap/cache

docker compose exec php chown -R www-data:www-data storage bootstrap/cache

docker compose exec php php artisan view:clear docker compose exec php php artisan config:clear docker compose exec php php artisan route:clear

Для миграций и других команд Laravel: docker compose exec php php artisan <команда>

База данных MySQL доступна через любые DB-клиенты по адресу: Хост: 127.0.0.1 Порт: 3306 Пользователь: laravel Пароль: secret База данных: laravel

DB_CONNECTION=mysql DB_HOST=mysql DB_PORT=3306 DB_DATABASE=laravel DB_USERNAME=laravel DB_PASSWORD=secret
