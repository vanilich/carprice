<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class CityController extends Controller {

		/**
		* Получить все города
		**/
		public function all(Request $request, Response $response, array $args) {
			$city = $this->container->db->getAll('SELECT * FROM city;');

		    return $this->container->renderer->render($response, 'city.phtml', [
		    	'city' => $city
		    ]);
		}

		/**
		* Удалить город по id
		**/
		public function remove(Request $request, Response $response, array $args) {
			$id = intval($request->getAttribute('id'));

			$this->container->db->query('DELETE FROM city WHERE id=?i', $id);

		    return $response->withRedirect('/city');
		}

		/**
		* Добавить город
		**/
		public function add(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['city']) AND !empty($body['city']) ) {
				$city = $body['city'];

				$this->container->db->query('INSERT INTO city(name) VALUES(?s)', $city);
			}

		    return $response->withRedirect('/city');
		}				
	}