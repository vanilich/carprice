<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class ModelController extends Controller {

		/**
		* Получить информацию о модели автомобился по id
		**/
		public function get(Request $request, Response $response, array $args) {
			$id = intval($request->getAttribute('id'));

		    $model = $this->container->db->getAll('SELECT * FROM model WHERE mark_id=?i', $id);

		    if($model) {
		    	return $response->withJson($model);
		    }
		}

		/**
		* Добавляем модель автомобиля
		**/
		public function add(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['mark']) AND !empty($body['mark']) AND isset($body['name']) AND !empty($body['name']) ) {
				$mark = intval($body['mark']);
				$name = $body['name'];

				$this->container->db->query('INSERT INTO model(mark_id, name) VALUES(?s, ?s)', $mark, $name);
			}

		    return $response->withRedirect('/cars');
		}

		/**
		* Редактируем модель автомобиля
		**/
		public function edit(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['name']) AND !empty($body['name']) AND isset($body['id']) AND !empty($body['id']) ) {
				$id = intval($body['id']);
				$name = $body['name'];

				$this->container->db->query('UPDATE model SET name=?s WHERE id=?i', $name, $id);
			}

		    return $response->withRedirect('/cars');
		}

		/**
		* Удаляем модель автомобиля по переданному id
		**/
		public function remove(Request $request, Response $response, array $args) {
			$id = intval($request->getAttribute('id'));

			$this->container->db->query('DELETE FROM model WHERE id=?i', $id);

		    return $response->withRedirect('/cars');
		}				
	}