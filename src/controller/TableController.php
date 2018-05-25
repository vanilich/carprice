<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class TableController extends Controller {

		/**
		* Вывод основной таблицы с ценами на автомобили
		* В основной вызываем с главной страницы с помощью Ajax
		**/
		public function table(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			// Марка автомобиля
			$mark =  isset($body['mark']) ? intval($body['mark']) : 0;
			// Модель автомобиля
			$model = isset($body['model']) ? intval($body['model']) : 0;
			// Магазины
			$shop =  isset($body['shop']) ? $body['shop'] : [];
			// Города
			$city =  isset($body['city']) ? $body['city'] : [];

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
		    	$query .= $this->container->db->parse(" AND model.mark_id = ?i", $mark);
		    }
		    if( isset($model) AND !empty($model) AND $model !== 0 ) {
		    	$query .= $this->container->db->parse(" AND model.id = ?i", $model);
		    }

		    $cars  = $this->container->db->getAll($query);
		    // ------------------------------------------------

		    $price = $this->container->db->getAll("SELECT price.*, shop.template as 'parent_template' FROM price INNER JOIN shop ON shop.id=price.shop_id;");
		    $mark = $this->container->db->getAll('SELECT * FROM mark;');

		    // ------------------------------------------------

		    // ------------------------------------------------
		    $query = "SELECT id as 'shop_id', name FROM shop WHERE 1";

		    // Фильтруем данные по "городу" и "автосалону"
		    if( isset($shop) AND !empty($shop) AND is_array($shop) ) {
		    	$query .= $this->container->db->parse(" AND id IN(?a)", $shop);
		    }
		    if( isset($city) AND !empty($city) AND is_array($city) ) {
		    	$query .= $this->container->db->parse(" AND city_id IN(?a)", $city);
		    }

		    $query .= " ORDER by name DESC;";
		    $shop  = $this->container->db->getAll($query);
		    // ------------------------------------------------

		    // Собираем таблицу с данными
		    $data = $this->builtTable($cars, $price, $shop);

		    // И отдаем клиенту...
		    return $this->container->renderer->render($response, 'table.phtml', [
		    	'data' => $data,
		    	'shop' => $shop,
		    	'mark' => $mark
		    ]);
		}

		/**
		* Выгрузка шаблона в Excel
		**/
		public function excel(Request $request, Response $response, array $args) {
			ob_end_clean();

			/**
				$city = isset($_COOKIE["city"]) && $_COOKIE["city"] ? $_COOKIE["city"] : 1;

				$dataArray1 = [['Марка','Модель',],];
				$dataArray2 = [];

				foreach ($data->getShops($city) as $row) {
				    $dataArray2[] = $row['name'];
				}

				$dataArray = [];
				$dataArray[0] = array_merge($dataArray1[0], $dataArray2);

				$dataArray3 = [];
				$dataArray4 = [];
				$i = 0;
				foreach ($data->getModels() as $row) {
				    $i++;
				    $dataArray4 = [[$row['car'],$row['model']],] ;
				    $dataArray5 = [];

				    foreach ($data->getShops($city) as $row_shop) {
				        $priceInfo = $data->getPriceInfo($row_shop['id'],$row['model_id']);
				        $dataArray5[] = $priceInfo['price'];
				    }

				    $dataArray[$i] = array_merge($dataArray4[0], $dataArray5);

				    unset($dataArray4);
				    unset($dataArray5);
				}

			**/
			
			$doc = new PHPExcel();
			$doc->setActiveSheetIndex(0);
			$filename = 'price-' . date("Y-m-d H:i:s") . '.xls';

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
			$objWriter->save('php://output');
		}

		// TODO Model
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