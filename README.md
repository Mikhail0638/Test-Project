# Тестовое задание на позицию php разработчика

API записной книжки

## Описание

Структура методов:

    1.1. GET /api/v1/notebook/
    1.2. POST /api/v1/notebook/
    1.3. GET /api/v1/notebook/<id>/
    1.4. POST /api/v1/notebook/<id>/
    1.5. DELETE /api/v1/notebook/<id>/
    1.6. GET /api/documentation
    
Информация выводится постранично (по 5 записей на странице)
    
Поля для POST-метода записной книжки: 
   
    1. fullname - ФИО (обязательное)
    2. company - компания
    3. phone - телефон (обязательное)
    4. email - email (обязательное)
    5. birthdate - дата рождения 
    6. photo - фото

## Настройка

Для создания контейнера Docker нужно прописать в корневой директории проекта: docker-compose up --build
Для добавления необходимых таблиц в базу данных, в основном контейнере (test-project) в консоле необходимо прописать: php artisan migrate

## Тесты (PHPUnit)

Тесты для проверки работы методов находятся по следующему пути: tests/Feature/NotebookApiTest.php
Для выполнения тестирования необходимо прописать: php artisan test

## Swagger

Подробное описание методов (Swagger UI): GET /api/documentation

## Docker

Данные MySQL:
Логин: root
Пароль: 123451
База данных: notebook

Веб-сервер: localhost:8000
PhpMyAdmin: localhost:8080


