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
            'host'  => '127.0.0.1',
            'user'  => 'root',
            'pass'  => '',
            'db'    => 'carprice',
        ],

        'auth' => [
            'user' => 'admin',
            'pass' => 'admin'
        ]

    ],
    'commands' => [
        // Обновление цены на сайте
        'RefreshPriceTask' => \RefreshPriceTask::class,

        // Работа с миграциями базы данных
        'MigrationUpTask' => \MigrationUpTask::class,
        'MigrationDownTask' => \MigrationDownTask::class
    ],    
];
