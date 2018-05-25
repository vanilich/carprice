<?php
	class PriceModel extends BaseModel {

		/**
		* Генерируем таблицу с ценами
		* @param int $mark ID марки автомобиля
		* @param int $model ID модели автомобиля
		* @param array $shop Список ID автосалонов
		* @param array $city Список ID городов
		* @return mixed
		**/
		public function getTable($mark = 0, $model = 0, array $shop = [], array $city = []) {
			// ------------------------------------------------
		    $query = "";
		    $query .= "SELECT ";
		    $query .= " 	model.id as 'model_id', ";
		    $query .= " 	model.name as 'model_name', ";
		    $query .= " 	mark.name as 'mark_name' ";
		    $query .= "FROM model  ";
		    $query .= "		INNER JOIN mark ON model.mark_id = mark.id";

		    // Фильтруем данные по "марке" и "модели" автомобиля
		    if( isset($mark) AND !empty($mark) AND $mark !== 0 ) {
		    	$query .= $this->db->parse(" AND model.mark_id = ?i", $mark);
		    }
		    if( isset($model) AND !empty($model) AND $model !== 0 ) {
		    	$query .= $this->db->parse(" AND model.id = ?i", $model);
		    }
		    $cars  = $this->db->getAll($query);
		    // ------------------------------------------------

		    // Получаем цены
		    $price = $this->getPriceWithParentShopTempalte();

		    // Получаем автосалоны
		    $shopModel = new ShopModel($this->db);
		    $shop = $shopModel->getShop($shop, $city);

		    // Собираем таблицу с данными
		    $data = $this->builtTable($cars, $price, $shop);

		    // И отдаем клиенту...
		    return [
		    	'data' => $data,
		    	'shop' => $shop,
		    	'mark' => $this->db->getAll('SELECT * FROM mark;')		    
		    ];
		}

		/**
		* Получаем данные из таблицы price вместе с родительским шаблоном из таблицы shop
		* @return mixed
		**/
		public function getPriceWithParentShopTempalte() {
			return $this->db->getAll("SELECT price.*, shop.template as 'parent_template' FROM price INNER JOIN shop ON shop.id=price.shop_id;");
		}

		/**
		* Генерируем матрицу на основе данных из базы данных
		**/
		public function builtTable($cars, $price, $shop) {
		    $data = [];

		    foreach ($cars as $key => $value) {
		    	$data[] = $value;

		    	$tmp = array_pop($data);
		    	$tmp['shop'] = $shop;

		    	array_push($data, $tmp);
		    }

		    foreach ($price as $priceKey => $priceValue) {
		    	$modelId = $priceValue['model_id'];
		    	$shopId = $priceValue['shop_id'];

		    	foreach ($data as $modelKey => $modelValue) {
		    		if( $modelValue['model_id'] === $modelId ) {
		    			foreach ($modelValue['shop'] as $shopKey => $shopValue) {
		    				if( $shopValue['shop_id'] === $shopId ) {
		    					$data[$modelKey]['shop'][$shopKey]['price'] = $priceValue;
		    				}
		    			}
		    			break;
		    		}
		    	}
		    }

		    return $data;
		}
	}