<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class PriceController extends Controller {

		/**
		* Добавление цены
		**/
		public function add(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['shop']) AND isset($body['mark']) AND isset($body['model']) AND isset($body['template']) AND isset($body['url']) ) {
				$shop = $body['shop'];
				$mark = $body['mark'];
				$model = $body['model'];
				$template = $body['template'];
				$url = $body['url'];

				if( !empty($template) ) {
					$this->container->db->query('INSERT INTO price(shop_id, model_id, url, template) VALUES(?i, ?i, ?s, ?s)', $shop, $model, $url, $template);
				} else {
					$this->container->db->query('INSERT INTO price(shop_id, model_id, url) VALUES(?i, ?i, ?s)', $shop, $model, $url);
				}	
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
					$this->container->db->query('UPDATE price SET url=?s, template=?s WHERE id=?i', $url, $template, $id);
				} else {
					$this->container->db->query('UPDATE price SET url=?s WHERE id=?i', $url, $id);
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
	}