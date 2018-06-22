<?php
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

class BaseTest extends TestCase {

    protected $withMiddleware = true;

    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        $request = Request::createFromEnvironment($environment);

        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        $response = new Response();

        $settings = require __DIR__ . '/../../src/settings.php';

        $app = new App($settings);

        require __DIR__ . '/../../src/dependencies.php';

        if ($this->withMiddleware) {
            require __DIR__ . '/../../src/middleware.php';
        }
        require __DIR__ . '/../../src/routes.php';

        $response = $app->process($request, $response);

        return $response;
    }

}