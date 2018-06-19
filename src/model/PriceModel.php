<?php
    use \Interop\Container\ContainerInterface;
    use \Sunra\PhpSimple\HtmlDomParser;

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
		    $query .= "		INNER JOIN mark ON model.mark_id = mark.id ";

		    // Фильтруем данные по "марке" и "модели" автомобиля
		    if( isset($mark) AND !empty($mark) AND $mark !== 0 ) {
		    	$query .= $this->db->parse(" AND model.mark_id = ?i", $mark);
		    }
		    if( isset($model) AND !empty($model) AND $model !== 0 ) {
		    	$query .= $this->db->parse(" AND model.id = ?i", $model);
		    }

		    // Добавил сортировку по названию марки и модели автомобиля
		    $query .= "ORDER BY mark.name, model.name";

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
		    	'mark' => $this->db->getAll('SELECT * FROM mark;'),
		    	'empty' => empty($shop)	    
		    ];
		}

		/**
		* Получаем данные из таблицы price вместе с родительским шаблоном из таблицы shop
		* @return mixed
		**/
		public function getPriceWithParentShopTempalte($priceId = NULL) {
		    if($priceId == NULL) {
                return $this->db->getAll("SELECT price.*, shop.template as 'parent_template' FROM price INNER JOIN shop ON shop.id=price.shop_id;");
            } else {
                return $this->db->getRow("SELECT price.*, shop.template as 'parent_template' FROM price INNER JOIN shop ON shop.id=price.shop_id AND price.id=?i;", $priceId);
            }
		}


		/**
		* Парсим цену с стороннего сайта
		**/
		public static function parse($url, $template) {
			// Проверяем ссылку на доступность
			if( Helper::check404($url) !== 404 AND Helper::check404($url) !== 0 ) { 
				$dom = HtmlDomParser::str_get_html( @file_get_contents($url) );

				if($dom) {
					// Парсим цену с помощью шаблона
					$price = @$dom->find($template, 0)->innertext;

					if($price) {
                        // Удаляем из цены html тэги и оставляем только цифры
                        $price = strip_tags($price);
                        $price = preg_replace("/[^0-9]/", '', $price);

                        return $price;
                    }
				}
			}
			return false;
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