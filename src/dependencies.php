<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $template_path = $c->get('settings')['renderer']['template_path'];

    // Преобразуем std::class в array
    $settings = (array) $c->get('settings');
    // Извлекаем настройки по первому ключю ассоциативного массива
    $settings['config'] = $settings[key($settings)];

    return new Slim\Views\PhpRenderer($template_path, $settings['config']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['db'] = function ($container) {
    return new SafeMySQL($container->get('settings')['db']);
};