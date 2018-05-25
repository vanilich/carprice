<?php
	// Авторизация
	$app->get('/login', 	\LoginController::class . ':login');
	$app->post('/login', 	\LoginController::class . ':doLogin');
	$app->any('/logout', 	\LoginController::class . ':logout');


	$app->group('', function() {
		// Главная страница
		$this->get('/', 		\MainController::class . ':index');
		// Список моделей и марок автомобилей
		$this->get('/cars', 	\MainController::class . ':cars');
		// Страница с автосалонами
		$this->get('/shop', 	\MainController::class . ':shop');

		// Вывод таблицы с ценами
		$this->any('/table',	\TableController::class . ':table');
		// Выгрузка в Excel
		$this->any('/excel',	\TableController::class . ':excel');

		// Работа с моделями автомобилей
		$this->get('/model/{id}', 		 \ModelController::class . ':get');
		$this->post('/model/add', 		 \ModelController::class . ':add');
		$this->post('/model/edit', 		 \ModelController::class . ':edit');
		$this->get('/model/remove/{id}', \ModelController::class . ':remove');

		// Работа с городами
		$this->get('/city', 				\CityController::class . ':all');
		$this->get('/city/remove/{id}', 	\CityController::class . ':remove');
		$this->post('/city/add', 		\CityController::class . ':add');

		// Работа с марками автомобилей
		$this->post('/mark/add', 		\MarkController::class . ':add');
		$this->post('/mark/edit', 		\MarkController::class . ':edit');
		$this->get('/mark/remove/{id}', \MarkController::class . ':remove');

		// Работа с автосалонами
		$this->post('/shop/add', 		\ShopController::class . ':add');
		$this->get('/shop/remove/{id}', \ShopController::class . ':remove');
		$this->get('/shop/info/{id}', 	\ShopController::class . ':info');

		// Работа с ценами
		$this->post('/price/add', 		 \PriceController::class . ':add');
		$this->post('/price/edit', 		 \PriceController::class . ':edit');
		$this->get('/price/remove/{id}', \PriceController::class . ':remove');

	})->add( new AuthMiddleware() );