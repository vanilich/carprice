<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class MainController extends Controller {

		/**
		* Главная страница
		**/
		public function index(Request $request, Response $response, array $args) {
		    $mark = $this->container->db->getAll('SELECT * FROM mark;');
		    $city = $this->container->db->getAll('SELECT * FROM city;');
		    $shop  = $this->container->db->getAll("SELECT id as 'shop_id', name FROM shop ORDER by name DESC;");

		    $this->container->renderer->addAttribute('title', 'Главная страница');
		    return $this->container->renderer->render($response, 'index.phtml', [
		    	'shop' => $shop,
		    	'mark' => $mark,
		    	'city' => $city
		    ]);
		}
		
		/**
		* Список моделей и марок автомобилей
		**/
		public function cars(Request $request, Response $response, array $args) {
		    $query = "";
		    $query .= "SELECT ";
		    $query .= " 	model.id as 'model_id', ";
		    $query .= " 	model.name as 'model_name', ";
		    $query .= " 	mark.id as 'mark_id', ";
		    $query .= " 	mark.name as 'mark_name' ";
		    $query .= "FROM model  ";
		    $query .= "		INNER JOIN mark ON model.mark_id = mark.id";

			$cars = $this->container->db->getAll($query);
			$mark = $this->container->db->getAll('SELECT * FROM mark;');

			$this->container->renderer->addAttribute('title', 'Автомобили');
		    return $this->container->renderer->render($response, 'cars.phtml', [
		    	'cars' => $cars,
		    	'mark' => $mark
		    ]);			
		}

		/**
		* Страница с автосалонами
		**/
		public function shop(Request $request, Response $response, array $args)  {
			$shop = $this->container->db->getAll('SELECT * FROM shop;');
			$city = $this->container->db->getAll('SELECT * FROM city;');

			$this->container->renderer->addAttribute('title', 'Автосалоны');
		    return $this->container->renderer->render($response, 'shop.phtml', [
		    	'shop' => $shop,
		    	'city' => $city
		    ]);			
		}

		public function stub(Request $request, Response $response, array $args) {
            return $this->container->renderer->render($response, 'stub.phtml');
        }
	}