# Парсер цен на автомобили

Парсер цен на автомобили с официальных сайтов диллеров и выгрузка информации в Excel.

### Установка

```
1. git clone https://github.com/vanilich/carprice.git
2. php composer.phar update
2. Создаем .env файл в корневой директории проекта
3. Создаем дамп бд: php index.php ExecuteSQLTask.php up
4. НАполняем его данными: php index.php ExecuteSQLTask.php data
```

### Пример .env файла

```
MYSQL_HOST=127.0.0.1
MYSQL_USER=root
MYSQL_PASS=
MYSQL_DATABASE=carprice
```

### Настройки проекта

Все настройки проекта содержатся в файле src/settings.php

### Работа с миграциями базы данных

В проекте используется самописная система работы с миграциями баз данных. 
Вся суть заключается в файле src/task/ExecuteSQLTask.php, который выполняет произвольный SQL код. Пути до файлов находятся в конфиге settings.php в разделе 'migration'.

```
up - развернуть бэкап на сервере
down - очистить базу данных на сервере
data - восстановить данные
```