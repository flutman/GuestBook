# Webinar Laravel set local environment with Docker Compose


## Docker's command helpers

- Запуск контейнеров `docker-compose up -d --build`
- Остановка контейнеров `docker-compose down`
- Просмотреть логи `docker-compose logs --tal 25`

## Laravel command helpers

- Установка Laravel `composer global require laravel/installer`

## После запуска контейнера
- Сайт доступен по адресу http://localhost:7777/
- База данных доступна по адресу http://localhost:7760/

## Пареметры .env
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=webimar_laravel
DB_USERNAME=root
DB_PASSWORD=webimar_laravel 
````

