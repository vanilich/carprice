<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class ShopController extends Controller {

		/**
		* Добавление автосалона
		**/
		public function add(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['city']) AND isset($body['name']) AND isset($body['url']) AND isset($body['template']) ) {
				$city = $body['city'];
				$name = $body['name'];
				$url = $body['url'];
				$template = $body['template'];

				$this->container->db->query('INSERT INTO shop(city_id, name, url, template) VALUES(?i, ?s, ?s, ?s)', $city, $name, $url, $template);
			}

		    return $response->withRedirect('/shop');		   
		}

		/**
		* Удаление автосалона по id
		**/
		public function remove(Request $request, Response $response, array $args) {
			$id = intval($request->getAttribute('id'));

			$this->container->db->query('DELETE FROM shop WHERE id=?i', $id);

		    return $response->withRedirect('/shop');		   
		}

		/**
		* Информация об автосалоне
		**/
		public function info(Request $request, Response $response, array $args) {
			$id = intval($request->getAttribute('id'));

			$data = $this->container->db->getRow('SELECT * FROM shop WHERE id=?i', $id);

			if($data) {
				return $response->withJson($data);	
			}		   
		}

		/**
		* Редактирование автосалона
		**/
		public function edit(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['id']) AND isset($body['name']) AND isset($body['url']) AND isset($body['template']) ) {
				$id = intval($body['id']);
				$name = $body['name'];
				$url = $body['url'];
				$template = $body['template'];

				$this->container->db->query('UPDATE shop SET name=?s, url=?s, template=?s WHERE id=?i', $name, $url, $template, $id);

				return $response->withRedirect('/shop');  
			}
		}							
	}