<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class PriceController extends Controller {

		/**
		* Добавление цены
		**/
		public function add(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['shop']) AND isset($body['model']) AND isset($body['template']) AND isset($body['url']) ) {
				$shop = $body['shop'];
				$model = $body['model'];
				$template = $body['template'];
				$url = $body['url'];

				if( !empty($template) ) {
					$this->container->db->query('INSERT INTO price(shop_id, model_id, url, template, active) VALUES(?i, ?i, ?s, ?s, 1)', $shop, $model, $url, $template);
				} else {
					$this->container->db->query('INSERT INTO price(shop_id, model_id, url, active) VALUES(?i, ?i, ?s, 1)', $shop, $model, $url);
				}	
			}

		    return $response->withRedirect('/');		   
		}

        /**
         * Пакетное добавление цен
         */
		public function packet_add(Request $request, Response $response, array $args) {
            $body = $request->getParsedBody();

            if( isset($body['shop']) AND isset($body['model_id']) AND isset($body['template']) AND isset($body['url']) ) {
                $shop = $body['shop'];

                $queryParts = [];
                foreach($body['model_id'] as $key => $value) {
                    $model_id = intval($body['model_id'][$key]);
                    $template = ( !empty($body['template'][$key]) ) ? $body['template'][$key] : NULL;
                    $url = $body['url'][$key];

                    $queryParts[] = $this->container->db->parse("(?i, ?i, ?s, ?s, 1)", $shop, $model_id, $url, $template);
                }

                $query = "INSERT INTO price(shop_id, model_id, url, template, active) VALUES" . implode(", ", $queryParts);

                $this->container->db->query($query);
            }

            return $response->withRedirect('/');
        }

		/**
		* Редактирование цены
		**/
		public function edit(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['id']) AND isset($body['url']) AND isset($body['template']) ) {
				$id = $body['id'];
				$url = $body['url'];
				$template = $body['template'];

				if( !empty($template) ) {
					$this->container->db->query('UPDATE price SET url=?s, template=?s, active=1 WHERE id=?i', $url, $template, $id);
				} else {
					$this->container->db->query('UPDATE price SET url=?s, active=1 WHERE id=?i', $url, $id);
				}
			}	
			
			return $response->withRedirect('/');		
		}	

		/**
		* Удаление цены
		**/
		public function remove(Request $request, Response $response, array $args) {
			$id = intval($request->getAttribute('id'));

			$this->container->db->query('DELETE FROM price WHERE id=?i', $id);

		    return $response->withRedirect('/');	
		}	

		/**
		* Тест шаблона для поиска цены
		**/
		public function test(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['id']) AND isset($body['url']) AND isset($body['template']) ) {
				$id = $body['id'];
				$url = $body['url'];
				$template = $body['template'];

				// Если пользователь не заполнил поле с шаблоном, то:
				if( empty($template) ) {
					// Получаем родительский класс шаблона (таблица shop) для поиска цена
					$template = $this->container->db->getOne('SELECT shop.template FROM price INNER JOIN shop ON price.id = ?i AND price.shop_id = shop.id LIMIT 1', $id);
				}

				// Парсим цену с сайта
				if( ($price = PriceModel::parse($url, $template)) !== false ) {

					$this->container->db->query("UPDATE price SET price=?i, updated_at=NOW(), active=1 WHERE id=?i", $price, $id);

					return $response->withJson( ['price' => $price] );	
				} else {
					return $response->withJson( ['price' => ''] );	
				}
			}

		}

        /**
         * Получить список цен
         */
		public function get(Request $request, Response $response, array $args) {
            $body = $request->getParsedBody();

            if( isset($body['shop_id']) ) {
                $shop_id = $body['shop_id'];

                $result = $this->container->db->getAll("SELECT * FROM price WHERE shop_id=?i", $shop_id);

                return $response->withJson($result);
            }
        }

        /**
         * Обновление цены
         */
        public function refresh(Request $request, Response $response, array $args) {
            $body = $request->getParsedBody();

            if( isset($body['id']) ) {
                $id = intval($body['id']);

                $priceModel = new PriceModel($this->container->db);

                $result = $priceModel->getPriceWithParentShopTempalte($id);

                $id = $result['id'];
                $url = $result['url'];
                $template = !empty($result['template']) ? $result['template'] : $result['parent_template'];

                if( ($price = PriceModel::parse($url, $template)) !== false ) {

                    if( !empty($result['template']) ) {
                        $this->container->db->query("UPDATE price SET template=?s, price=?i, updated_at=NOW(), active=1 WHERE id=?i", $template, $price, $id);
                    } else {
                        $this->container->db->query("UPDATE price SET price=?i, updated_at=NOW(), active=1 WHERE id=?i", $price, $id);
                    }

                    return $response->withJson( ['status' => 'ok'] );
                } else {
                    return $response->withJson( ['status' => 'error'] );
                }
            }
        }

	}