<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'db' => [
            'host'  => getenv('MYSQL_HOST'),
            'user'  => getenv('MYSQL_USER'),
            'pass'  => getenv('MYSQL_PASS'),
            'db'    => getenv('MYSQL_DATABASE')
        ],

        'auth' => [
            'user' => 'admin',
            'pass' => 'admin'
        ],

        'migration' => [
            'up' => 'src/database/up.sql',
            'down' => 'src/database/down.sql'
        ]
    ],
    'commands' => [
        // Обновление цены на сайте
        'RefreshPriceTask' => \RefreshPriceTask::class,

        // Выполение произвольного sql кода
        'ExecuteSQLTask' => \ExecuteSQLTask::class
    ],    
];
