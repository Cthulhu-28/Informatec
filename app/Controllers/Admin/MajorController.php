<?php

namespace Informatec\Controllers\Admin;

use Informatec\Controllers\Controller;
use Informatec\Models\User;

use Respect\Validation\Validator as v;

class MajorController extends Controller
{
    public function getNewMajor($request, $response)
    {
        return $this->container->view->render($response, 'admin/majors/new.twig');
    }
}
