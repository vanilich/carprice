<?php
    class AuthMiddleware {

        public function __invoke($request, $response, $next)
        {
            if( !isset($_SESSION['auth']) ) {
                return $response->withRedirect('/login');
            }
            return $next($request, $response);
        }
    }