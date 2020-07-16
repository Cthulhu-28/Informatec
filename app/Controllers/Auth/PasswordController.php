<?php

namespace Informatec\Controllers\Auth;

use Informatec\Controllers\Controller;
use Informatec\Models\User;

use Respect\Validation\Validator as v;

class PasswordController extends Controller
{
    public function getChangePassword($request, $response)
    {
        return $this->container->view->render($response, 'auth/password.twig');
    }

    public function postChangePassword($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
            'password_old' => v::noWhitespace()->notEmpty()->matchesPassword($this->container->auth->user()->password),
            'password' => v::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->container->router->pathFor('auth.password.change'));
        }
        $this->container->auth->user()->setPassword($request->getParam('password'));
        $this->container->flash->addMessage('global', 'Password changed');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }
}
