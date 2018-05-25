<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class TableController extends Controller {

		/**
		* Вывод основной таблицы с ценами на автомобили
		* В основной вызываем с главной страницы с помощью Ajax
		**/
		public function table(Request $request, Response $response, array $args) {
			// Получаем данные от клиента
			$body = $request->getParsedBody();

			// Марка автомобиля
			$mark =  isset($body['mark']) ? intval($body['mark']) : 0;
			// Модель автомобиля
			$model = isset($body['model']) ? intval($body['model']) : 0;
			// Магазины
			$shop =  isset($body['shop']) ? $body['shop'] : [];
			// Города
			$city =  isset($body['city']) ? $body['city'] : [];

			// Создаем модель
		    $priceModel = new PriceModel($this->container->db);
		    // Генерируем таблицу
		    $data = $priceModel->getTable($mark, $model, $shop, $city);

		    // И отдаем клиенту...
		    return $this->container->renderer->render($response, 'table.phtml', $data);
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

	}