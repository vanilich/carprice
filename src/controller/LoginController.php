<?php
	use Slim\Http\Request;
	use Slim\Http\Response;

	class LoginController extends Controller {

		public function login(Request $request, Response $response, array $args) {
		    return $this->container->renderer->render($response, 'login.phtml');
		}

		public function doLogin(Request $request, Response $response, array $args) {
			$body = $request->getParsedBody();

			if( isset($body['login']) AND isset($body['password']) ) {
				$login = trim($body['login']);
				$password = trim($body['password']);

				if($login === $this->container->get('settings')['auth']['user'] AND $password === $this->container->get('settings')['auth']['pass']) {
					$_SESSION['auth'] = true;
					return $response->withRedirect('/');
				} else {
					return $response->withRedirect('/login');
				}
			}
		}

		public function logout(Request $request, Response $response, array $args) {
			unset($_SESSION['auth']);
			return $response->withRedirect('/login');
		}		
	}