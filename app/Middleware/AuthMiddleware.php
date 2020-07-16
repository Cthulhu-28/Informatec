<?php

namespace Informatec\Middleware;

class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        //$route = $request->getAttribute('route');
        if (!$this->container->auth->check()) {
            $this->container->flash->addMessage('global', 'Inicie sesión hp');
            return $response->withRedirect(
                $this->container->router->pathFor(
                    'auth.signin'/*,
                    [],
                    ['url' => $route->getName()]*/
                )
            );
        }
        $response  = $next($request, $response);
        return $response;
    }
}
