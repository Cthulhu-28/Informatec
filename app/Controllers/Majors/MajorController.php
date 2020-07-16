<?php

namespace Informatec\Controllers\Majors;

use Informatec\Controllers\Controller;

class MajorController extends Controller
{
    public function getMajorsList($request, $response)
    {
        return $this->container->view->render($response, 'majors/index.twig');
    }
}
