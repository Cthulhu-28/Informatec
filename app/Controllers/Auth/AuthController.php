<?php

namespace Informatec\Controllers\Auth;

use Informatec\Controllers\Controller;
use Informatec\Models\User;

use Respect\Validation\Validator as v;

class AuthController extends Controller
{

    public function getSignOut($request, $response)
    {
        $this->container->auth->logout();
        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function getSignIn($request, $response)
    {
        return $this->container->view->render($response, 'auth/signin.twig');
    }

    public function postSignIn($request, $response)
    {
        $auth = $this->container->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if (!$auth) {
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }
        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function getSignUp($request, $response)
    {
        return $this->container->view->render($response, 'auth/signup.twig');
    }

    public function postSignUp($request, $response)
    {

        $validation = $this->container->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->emailAvailable(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            return $response->withRedirect($this->container->router->pathFor('auth.signup'));
        }

        $user = User::create([
            'email' => $request->getParam('email'),
            'name' => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_BCRYPT, ['cost' => 10]),
            'active' => 1
        ]);
        return $response->withRedirect($this->container->router->pathFor('home'));
    }
}
