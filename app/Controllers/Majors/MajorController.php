<?php

namespace Informatec\Controllers\Majors;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use Informatec\Controllers\Controller;
use Informatec\Models\Major;
use Informatec\Models\MajorLocation;

class MajorController extends Controller
{
    public function getMajorsList($request, $response)
    {
        $list = Major::query()->join('major_location', 'majors.id', '=', 'major_location.id')
            ->get();
        return $this->container->view->render($response, 'majors/index.twig', ['majors' => $list]);
    }

    public function getMajor($request, $response, $args)
    {
        $id = $args['id'];
        $major = Major::find($id);
        $skills = $major->skills;
        $interests = $major->interests;
        $areas = $major->areas;
        foreach ($areas as $area) {
            $area->tasks = json_decode($area->tasks);
            $area->subareas = json_decode($area->subareas);
        }
        return $this->container->view->render(
            $response,
            'majors/see.twig',
            [
                'major' => $major,
                'location' => $major->location,
                'skills' => $skills,
                'interests' => $interests,
                'areas' => $areas
            ]
        );
    }

    public function testMajor($request, $response, $args)
    {
        $id = $args['id'];
        DB::beginTransaction();
        try {
            $major = new Major([
                'id' => $id,
                'name' => 'Major ' . $id,
                'description' => '',
                'color' =>  '',
                'video' => '',
                'status' => 1
            ]);
            if ($major->save()) {
                $location = new MajorLocation([
                    'id' => $id,
                    'x' => 10,
                    'y' => 10,
                    'building' => 'CX',
                    'link' => ''
                ]);
                $location->save();
            } else {
                throw new Exception("");
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $response->withRedirect($this->container->router->pathFor('majors.show', ['id' => $id]));
    }
}
