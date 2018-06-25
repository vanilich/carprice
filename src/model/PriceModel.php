<?php
    use \Interop\Container\ContainerInterface;
    use \Sunra\PhpSimple\HtmlDomParser;

	class PriceModel extends BaseModel {

	    // price.active field
        // Пока цена не обновлена
        const PRICE_NOT_UPDATED = 0;
	    // Хост найден, парсинг работает и цена отображается (Зеленый)
	    const PRICE_SUCCESS = 1;
	    // Хост найден, но цена не парсится (Желтый)
	    const DOM_ENTITY_NOT_FOUND = 2;
        // Хост не найден (Красный)
        const HOST_NOT_FOUND = 3;

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
		    	$query .= $this->db->parse(" AND model.mark_id = ?i ", $mark);
		    }
		    if( isset($model) AND !empty($model) AND $model !== 0 ) {
		    	$query .= $this->db->parse(" AND model.id = ?i ", $model);
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
		* Парсим цену с стороннего сайта\
        * @param $url string Ссылка на цену
        * @param @template string Наблон парсинга цены
        * @throws \PriceException Если не удается найти хост, шаблон или цену
        * @return string Значение цены
		**/
		public static function parse($url, $template) {
		    // Константа для класса HtmlDomParser
            @define('MAX_FILE_SIZE', 9999999999);

            // Получаем страницу с помощью Curl
            $page = PriceModel::getWebPage($url);

			// Проверяем ссылку на доступность
            if( $page['http_code'] !== 404 AND $page['http_code'] !== 0 ) {

                // Загружаем страницу в HTML парсер
                $dom = HtmlDomParser::str_get_html( $page['content'] );

				if($dom) {
					// Парсим цену с помощью шаблона
					$price = @$dom->find($template, 0)->innertext;

					if($price) {
                        // Удаляем из цены html тэги и оставляем только цифры
                        $price = strip_tags($price);
                        $price = preg_replace("/[^0-9]/", '', $price);
                        $price = str_replace(' ', '', $price);

                        return $price;
                    } else {
                        throw new \PriceException(PriceModel::DOM_ENTITY_NOT_FOUND);
                    }
                } else {
                    throw new \PriceException(PriceModel::DOM_ENTITY_NOT_FOUND);
                }
			} else {
			    throw new \PriceException(PriceModel::HOST_NOT_FOUND);
            }
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

		/**
         * Установить цену
         * @param $level integer Уровень ошибки. См. const PRICE_xxx...
         * @param $id integer ID цены
         * @param $url string ссылка на цену
         * @param $price integer Значение цены
         * @param $template string Шаблон для поиска цены
         * @return void
         */
		public function updatePrice($level, $id, $url, $price = NULL, $template = NULL) {
		    if($level === PriceModel::PRICE_SUCCESS) {
		        if($template != NULL) {
                    $this->db->query("UPDATE price SET url=?s, template=?s, price=?i, updated_at=NOW(), active=?i WHERE id=?i", $url, $template, $price, PriceModel::PRICE_SUCCESS, $id);
                } else {
                    $this->db->query("UPDATE price SET url=?s, price=?i, updated_at=NOW(), active=?i WHERE id=?i",  $url, $price, PriceModel::PRICE_SUCCESS, $id);
                }
            }

            if($level === PriceModel::DOM_ENTITY_NOT_FOUND) {
                $this->db->query("UPDATE price SET price=NULL, updated_at='2010-01-01 16:32:33', active=?i WHERE id=?i", PriceModel::DOM_ENTITY_NOT_FOUND, $id);
            }

            if($level === PriceModel::HOST_NOT_FOUND) {
                $this->db->query("UPDATE price SET price=NULL, updated_at='2010-01-01 16:32:33', active=?i WHERE id=?i", PriceModel::HOST_NOT_FOUND, $id);
            }
        }

        public static function getWebPage($url) {
            $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

            $options = array(
                CURLOPT_CUSTOMREQUEST  =>"GET",
                CURLOPT_POST           => false,
                CURLOPT_USERAGENT      => $user_agent,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING       => "",
                CURLOPT_AUTOREFERER    => true,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT        => 5,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            );

            $ch      = curl_init( $url );
            curl_setopt_array( $ch, $options );
            $content = curl_exec( $ch );
            $err     = curl_errno( $ch );
            $errmsg  = curl_error( $ch );
            $header  = curl_getinfo( $ch );
            curl_close( $ch );

            $header['errno']   = $err;
            $header['errmsg']  = $errmsg;
            $header['content'] = $content;

            unset($ch);

            return $header;
        }
	}