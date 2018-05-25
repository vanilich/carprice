<?php
	// Главная страница
	$app->get('/', 		\MainController::class . ':index')->add( new AuthMiddleware() );
	// Список моделей и марок автомобилей
	$app->get('/cars', 	\MainController::class . ':cars')->add( new AuthMiddleware() );
	// Страница с автосалонами
	$app->get('/shop', 	\MainController::class . ':shop')->add( new AuthMiddleware() );

	// Авторизация
	$app->get('/login', 	\LoginController::class . ':login');
	$app->post('/login', 	\LoginController::class . ':doLogin');
	$app->any('/logout', 	\LoginController::class . ':logout');

	// Вывод таблицы с ценами
	$app->any('/table',	\TableController::class . ':table')->add( new AuthMiddleware() );
	// Выгрузка в Excel
	$app->any('/excel',	\TableController::class . ':excel')->add( new AuthMiddleware() );

	// Работа с моделями автомобилей
	$app->get('/model/{id}', 		\ModelController::class . ':get')->add( new AuthMiddleware() );
	$app->post('/model/add', 		\ModelController::class . ':add')->add( new AuthMiddleware() );
	$app->post('/model/edit', 		\ModelController::class . ':edit')->add( new AuthMiddleware() );
	$app->get('/model/remove/{id}', \ModelController::class . ':remove')->add( new AuthMiddleware() );

	// Работа с городами
	$app->get('/city', 				\CityController::class . ':all')->add( new AuthMiddleware() );
	$app->get('/city/remove/{id}', 	\CityController::class . ':remove')->add( new AuthMiddleware() );
	$app->post('/city/add', 		\CityController::class . ':add')->add( new AuthMiddleware() );

	// Работа с марками автомобилей
	$app->post('/mark/add', 		\MarkController::class . ':add')->add( new AuthMiddleware() );
	$app->post('/mark/edit', 		\MarkController::class . ':edit')->add( new AuthMiddleware() );
	$app->get('/mark/remove/{id}', 	\MarkController::class . ':remove')->add( new AuthMiddleware() );

	// Работа с автосалонами
	$app->post('/shop/add', 		\ShopController::class . ':add')->add( new AuthMiddleware() );
	$app->get('/shop/remove/{id}', 	\ShopController::class . ':remove')->add( new AuthMiddleware() );
	$app->get('/shop/info/{id}', 	\ShopController::class . ':info')->add( new AuthMiddleware() );

	// Работа с ценами
	$app->post('/price/add', 		\PriceController::class . ':add')->add( new AuthMiddleware() );
	$app->post('/price/edit', 		\PriceController::class . ':edit')->add( new AuthMiddleware() );
	$app->get('/price/remove/{id}', \PriceController::class . ':remove')->add( new AuthMiddleware() );