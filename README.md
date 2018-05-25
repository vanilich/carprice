# Парсер цен на автомобили

Парсер цен на автомобили с официальных сайтов диллеров и выгрузка информации в Excel.

### Установка

```
1. git clone https://github.com/vanilich/carprice.git
2. php composer.phar update
2. Создаем .env файл в корневой директории проекта
3. php index.php ExecuteSQLTask.php data
4. php index.php ExecuteSQLTask.php up
```

### Пример .env файла

```
MYSQL_HOST=127.0.0.1
MYSQL_USER=root
MYSQL_PASS=
MYSQL_DATABASE=carprice
```