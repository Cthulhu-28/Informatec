<?php

namespace Informatec\Controllers;

use Informatec\Models\User;

class HomeController extends Controller
{
    public function index($request, $response)
    {
        return $this->container->view->render($response, 'home.twig');
    }

    public function contact($request, $response)
    {
        return $this->container->view->render($response, 'contact.twig');
    }
}
