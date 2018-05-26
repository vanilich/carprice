# Парсер цен на автомобили

Парсер цен на автомобили с официальных сайтов диллеров и выгрузка информации в Excel.

## Установка

```
1. git clone https://github.com/vanilich/carprice.git
2. php composer.phar update
3. Создаем .env файл в корневой директории проекта
4. Создаем дамп бд: php index.php ExecuteSQLTask up
5. Нвполняем его данными: php index.php ExecuteSQLTask insert
```

### Пример .env файла

```
MYSQL_HOST=127.0.0.1
MYSQL_USER=root
MYSQL_PASS=
MYSQL_DATABASE=carprice

DEBUG=1
```

### Настройки проекта

Все настройки проекта содержатся в файле src/settings.php


## Доступные Tasks приложения

```
Использование php index.php [имя task] [аргументы]
ExecuteSQLTask - выполение произвольного sql кода на сервере
RefreshPriceTask - парсинг и обновление цен на автомобили
```

## Работа с миграциями базы данных

В проекте используется самописная система работы с миграциями баз данных. 
Вся суть заключается в файле src/task/ExecuteSQLTask.php, который выполняет произвольный SQL код. Пути до файлов находятся в конфиге settings.php в разделе 'migration'.

```
Использование php index.php ExecuteSQLTask [имя sql скрипта]
up - развернуть бэкап на сервере
insert - вставить данные в таблицы
truncate - очистить таблицы от данных
down - удалить все таблицы из базы данных
```

## Структура php проекта

/src/

* controller - контроллеры
* database - sql файлы миграции бд
* middleware - посредники приложения
* model - бизнес-логика
* tasks - задачи, запускаемые из консоли
* application.php - входной файл приложения
* dependencies.php - зависимости
* helper.php - вспомональные фукнции и классы
* middleware.php - описание посредников приложения
* routes.php - маршруты
* settings.php - настройки
