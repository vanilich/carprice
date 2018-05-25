<?php
	define('PATH_TO_ENV', '.env');

	if (PHP_SAPI == 'cli-server') {
	    // To help the built-in PHP dev server, check if the request was actually for
	    // something which should probably be served as a static file
	    $url  = parse_url($_SERVER['REQUEST_URI']);
	    $file = __DIR__ . $url['path'];
	    if (is_file($file)) {
	        return false;
	    }
	}

	require __DIR__ . '/../vendor/autoload.php';

	session_start();

	// Устанавливаем переменные окружения
	if( file_exists(PATH_TO_ENV) ) {
		$data = parse_ini_file(PATH_TO_ENV);

		foreach ($data as $key => $value) {
			putenv("$key=$value");
		}
	}

	$settings = require __DIR__ . '/../src/settings.php';
	$app = new \Slim\App($settings);

	require __DIR__ . '/../src/dependencies.php';

	require __DIR__ . '/../src/middleware.php';

	require __DIR__ . '/../src/routes.php';

	$app->run();
