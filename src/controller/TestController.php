<?php
use Slim\Http\Request;
use Slim\Http\Response;

class TestController extends Controller {

    public function price(Request $request, Response $response, array $args) {
        return $this->container->renderer->render($response, 'test/price.phtml');
    }

    public function price404(Request $request, Response $response, array $args) {
        return $response->withStatus(404);
    }

}