<?php

namespace Informatec\Controllers\Admin;

use Informatec\Controllers\Controller;
use Informatec\Models\Area;
use Informatec\Models\Major;
use Informatec\Models\User;
use Respect\Validation\Validator as v;

class MajorController extends Controller
{
    public function getMajorsList($request, $response)
    {
        $list = Major::all();
        // $list = $list->toArray();
        // var_dump($list);
        // die();
        return $this->container->view->render($response, 'admin/majors/index.twig', ['majors' => $list]);
    }

    public function getNewMajor($request, $response)
    {
        return $this->container->view->render($response, 'admin/majors/new.twig');
    }

    public function postNewMajor($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
            'major_id' => v::majorAvailable()
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->container->router->pathFor('admin.majors.new'));
        }

        $data = [
            'id' => $request->getParam('major_id'),
            'name' => $request->getParam('major_name'),
            'description' => $request->getParam('major_profile'),
            'color' =>  $request->getParam('major_color'),
            'video' => $request->getParam('major_video'),
            'status' => 1,
            'location' => [
                'id' => $request->getParam('major_id'),
                'x' => $request->getParam('x_value'),
                'y' => $request->getParam('y_value'),
                'building' => $request->getParam('major_building'),
                'link' => $request->getParam('major_google'),
            ]
        ];
        $ex =  $this->container->major->newMajor($data);
        if ($ex) {
            print_r($ex);
            $this->container->flash->addMessage('error', 'No se puedo efectuar los cambios');
            return $response->withRedirect($this->container->router->pathFor('admin.majors.new'));
        }
        return $response->withRedirect($this->container->router->pathFor('admin.home'));
    }

    public function postUpdateMajor($request, $response)
    {
        $validation = $this->container->validator->validate($request, [
            'major_id' => v::majorAvailable()
        ]);
        $data = [
            'id' => $request->getParam('major_id'),
            'name' => $request->getParam('major_name'),
            'description' => $request->getParam('major_profile'),
            'color' =>  $request->getParam('major_color'),
            'video' => $request->getParam('major_video'),
            'status' => 1,
            'location' => [
                'id' => $request->getParam('major_id'),
                'x' => $request->getParam('x_value'),
                'y' => $request->getParam('y_value'),
                'building' => $request->getParam('major_building'),
                'link' => $request->getParam('major_google'),
            ]
        ];
        $ex =  $this->container->major->updateMajor($data);
        if ($ex) {
            // throw $ex;
            $this->container->flash->addMessage('error', 'No se puedo efectuar los cambios');
            return $response->withRedirect($this->container->router->pathFor('admin.majors.edit', ['id' => $request->getParam('major_id')]));
        }
        return $response->withRedirect($this->container->router->pathFor('admin.majors.edit', ['id' => $request->getParam('major_id')]));
    }

    public function getEditMajor($request, $response, $args)
    {
        $id = $args['id'];
        $major = Major::find($id);
        return $this->container->view->render(
            $response,
            'admin/majors/edit.twig',
            [
                'major' => $major,
                'location' => $major->location,
                'skills' => $major->skills,
                'interests' => $major->interests,
                'areas' => $major->areas
            ]
        );
    }

    public function postEditMajor($request, $response, $args)
    {
        $id = $args['id'];
        $newSkills = $request->getParam('newSkills');
        $deletedSkills = $request->getParam('deletedSkills');
        $oldSkills = $request->getParam('oldSkills');
        $newInterests = $request->getParam('newInterests');
        $oldInterests = $request->getParam('oldInterests');
        $deletedInterests = $request->getParam('deletedInterests');

        if ($newSkills && count($newSkills) > 0) {
            $ex = $this->container->major->addSkills($id, $newSkills);
            if ($ex) {
                return $response->withStatus(400)->withJson(['msg' => 'BAD']);
            }
        }
        if ($deletedSkills && count($deletedSkills) > 0) {
            $ex = $this->container->major->deleteSkills($deletedSkills);
            if ($ex) {
                return $response->withStatus(400)->withJson(['msg' => 'BAD']);
            }
        }
        if ($oldSkills && count($oldSkills) > 0) {
            $ex = $this->container->major->updateSkills($oldSkills);
            if ($ex) {
                return $response->withStatus(400)->withJson(['msg' => 'BAD']);
            }
        }
        if ($newInterests && count($newInterests) > 0) {
            $ex = $this->container->major->addInterests($id, $newInterests);
            if ($ex) {
                return $response->withStatus(400)->withJson(['msg' => 'BAD']);
            }
        }
        if ($deletedInterests && count($deletedInterests) > 0) {
            $ex = $this->container->major->deleteInterests($deletedInterests);
            if ($ex) {
                return $response->withStatus(400)->withJson(['msg' => 'BAD']);
            }
        }
        if ($oldInterests && count($oldInterests) > 0) {
            $ex = $this->container->major->updateInterests($oldInterests);
            if ($ex) {
                return $response->withStatus(400)->withJson(['msg' => 'BAD']);
            }
        }
        return $response->withStatus(200)->withJson(['msg' => 'OK']);
    }

    public function getNewArea($request, $response, $args)
    {
        $id = $args['id'];
        $major = Major::find($id);
        return $this->container->view->render(
            $response,
            'admin/majors/areas/new.twig',
            [
                'major' => $major
            ]
        );
    }

    public function postNewArea($request, $response, $args)
    {
        $id = $args['id'];
        $data = [
            'area' => $request->getParam('area_name')[0],
            'tasks' => json_encode($request->getParam('task')),
            'subareas' => json_encode($request->getParam('area')),
            'major_id' => $id
        ];
        $ex = $this->container->major->newArea($data);
        if ($ex) {
            return $response->withRedirect($this->container->router->pathFor('admin.majors.areas.new'));
        } else {
            return $response->withRedirect($this->container->router->pathFor('admin.majors.edit', ['id' => $id]));
        }
    }

    public function getEditArea($request, $response, $args)
    {
        $area_id = $args['area'];
        $id = $args['id'];
        $major = Major::find($id);
        $area = Area::find($area_id);
        $area->tasks = json_decode($area->tasks);
        $area->subareas = json_decode($area->subareas);
        return $this->container->view->render(
            $response,
            'admin/majors/areas/edit.twig',
            [
                'area' => $area,
                'major' => $major
            ]
        );
    }

    public function postEditArea($request, $response, $args)
    {
        $area_id = $args['area'];
        $id = $args['id'];
        $data = [
            'id' => $area_id,
            'area' => $request->getParam('area_name')[0],
            'tasks' => json_encode($request->getParam('task')),
            'subareas' => json_encode($request->getParam('area')),
            'major_id' => $id
        ];
        $ex = $this->container->major->updateArea($data);
        if ($ex) {
            return $response->withRedirect($this->container->router->pathFor('admin.majors.edit', ['id' => $id]));
        } else {
            return $response->withRedirect($this->container->router->pathFor('admin.majors.areas.edit', ['id' => $id, 'area' => $area_id]));
        }
    }

    public function deleteArea($request, $response, $args)
    {
        $area_id = $args['area'];
        $ex = $this->container->major->deleteArea($area_id);
        if ($ex) {
            return $response->withStatus(400)->withJson(['msg' => $ex]);
        } else {
            return $response->withStatus(200)->withJson(['msg' => 'OK']);
        }
    }
}
