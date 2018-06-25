<?php
    class StubMiddleware {

        public function __invoke($request, $response, $next)
        {
            if (!isset($_COOKIE['admin']) AND $_SERVER['REQUEST_URI'] !== '/stub') {
                return $response->withRedirect('/stub');
            }
            return $next($request, $response);
        }
    }