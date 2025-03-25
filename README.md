# MiniCRM Party Rooms

## Описание проекта
MiniCRM Party Rooms — это веб-приложение для управления бронированием и резервированием помещений для вечеринок.

## Требования
- Docker
- Docker Compose

## Установка и настройка

### 1. Клонировать репозиторий
```bash
git clone https://github.com/4kerus/minicrm-party-rooms.git && cd minicrm-party-rooms
```

### 2. Скопировать .env
```bash
cp .env.example .env
```

### 3. Запустить приложение
```bash
docker compose pull && docker compose build && docker compose up -d
```

### 4. Установить зависимости
```bash
docker compose exec php composer install && docker compose exec php php artisan key:generate
```

### 5. Настройка базы данных
Запустите миграции и заполните базу данных:
```bash
docker compose exec php php artisan migrate:refresh --seed
```

### 6. Установить разрешения
Обеспечьте права доступа к файлам:
```bash
docker compose exec php chmod -R 775 storage bootstrap/cache \
  && docker compose exec php chown -R www-data:www-data storage bootstrap/cache
```

## Остановка контейнеров
```sh
docker compose down
```

## Дополнительная информация
- После установки доступ к приложению можно получить по адресу `http://localhost`.
- Для работы с Artisan используйте `docker compose exec php php artisan <command>`.
- Для работы с Npm используйте `docker compose run --rm node npm <command>`.
