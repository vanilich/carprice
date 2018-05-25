<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class MarkController extends Controller {

		/**
		* Добавить марку автомобиля
		**/
		public function add(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['name']) AND !empty($body['name']) ) {
				$name = $body['name'];

				$this->container->db->query('INSERT INTO mark(name) VALUES(?s)', $name);
			}

		    return $response->withRedirect('/cars');			
		}

		/**
		* Редактировать марку автомобиля
		**/
		public function edit(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['name']) AND !empty($body['name']) AND isset($body['id']) AND !empty($body['id']) ) {
				$id = intval($body['id']);
				$name = $body['name'];

				$this->container->db->query('UPDATE mark SET name=?s WHERE id=?i', $name, $id);
			}

		    return $response->withRedirect('/cars');			
		}

		/**
		* Удалить марку автомобился по id
		**/
		public function remove(Request $request, Response $response, array $args) {
			$id = intval($request->getAttribute('id'));

			$this->container->db->query('DELETE FROM mark WHERE id=?i', $id);

		    return $response->withRedirect('/cars');			
		}						
	}