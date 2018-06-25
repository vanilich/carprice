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

			$shop = $data['shop'];
			$mark = $data['mark'];
			$data = $data['data'];

			ob_end_clean();

			// Создаем Excel файл
			$doc = new PHPExcel();

			$doc->setActiveSheetIndex(0);
			$sheet = $doc->getActiveSheet();

			// Заполняем таблицу марками и моделями автомобилей
			$sheet->setCellValue("A1", 'Марка');
			$sheet->setCellValue("B1", 'Модель');

			$i=2;
            foreach ($data as $key => $value) {
                $sheet->setCellValue("A$i", $value['mark_name']);
                $sheet->setCellValue("B$i", $value['model_name']);

                $i++;
            }

            // Выводим список автосалонов
            $tmp = [];
            foreach ($shop as $value) {
            	$tmp[] = $value['name'];
            }
            $sheet->fromArray($tmp, null, 'C1');

            // Цены на автомобили
            $i=2;
            foreach ($data as $key => $value) {
            	$tmp = [];
            	foreach($value['shop'] as $item) {
            		if( isset($item['price']) AND !empty($item['price']['price']) AND $item['price']['price'] != 0 ) {
            			$tmp[] = number_format($item['price']['price'], 0, '', ' ');
            		} else {
            			$tmp[] = '';
            		}
            		$sheet->fromArray($tmp, null, "C$i");
            	}
            	$i++;
            }

            // Имя Excel файла
			$filename = 'price-' . date("Y-m-d H.i.s") . '.xls';
			$path = 'res/' . $filename;

			$objWriter = @PHPExcel_IOFactory::createWriter($doc, 'Excel5');
			@$objWriter->save($path);

			return $response->withJson([
				'url' => $path
			]);	
		}

	}