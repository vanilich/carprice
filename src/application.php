<?php
	define('PATH_TO_ENV', __DIR__ . '/../.env');

	// Устанавливаем переменные окружения
	if( file_exists(PATH_TO_ENV) ) {
		$data = parse_ini_file(PATH_TO_ENV);

		foreach ($data as $key => $value) {
			putenv("$key=$value");
		}
	} else {
		throw new RuntimeException("Cannot find '.env' file");
	}

	// Если включен дебаг-mode, то выводим все ошибки
	if( getenv('DEBUG') == "1" ) {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	} else {
		ini_set('display_errors', '0');
	}

	if (PHP_SAPI == 'cli-server') {
	    // To help the built-in PHP dev server, check if the requestSTUB was actually for
	    // something which should probably be served as a static file
	    $url  = parse_url($_SERVER['REQUEST_URI']);
	    $file = __DIR__ . $url['path'];
	    if (is_file($file)) {
	        return false;
	    }
	}

	require __DIR__ . '/../vendor/autoload.php';

	session_start();

	$settings = require __DIR__ . '/../src/settings.php';
	$app = new \Slim\App($settings);

	require __DIR__ . '/../src/helper.php';

	require __DIR__ . '/../src/dependencies.php';

	require __DIR__ . '/../src/middleware.php';

	require __DIR__ . '/../src/routes.php';

	$app->run();
