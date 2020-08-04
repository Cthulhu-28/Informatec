<?php

namespace Informatec\Data\Major;

use Informatec\Models\Major as MajorDB;
use Informatec\Models\MajorLocation;
use Informatec\Models\Skill;
use Exception;
use Informatec\Models\Area;
use Illuminate\Database\Capsule\Manager as DB;
use Informatec\Models\Interest;

class Major
{
    public function newMajor(array $data)
    {
        DB::beginTransaction();
        try {
            $major = new MajorDB([
                'id' => $data['id'],
                'name' => $data['name'],
                'description' => $data['description'],
                'color' =>  $data['color'],
                'video' => $data['video'],
                'status' => 1
            ]);
            if ($major->save()) {
                $location = new MajorLocation($data['location']);
                $location->save();
            } else {
                throw new Exception("");
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function updateMajor(array $data)
    {
        DB::beginTransaction();
        try {
            $major = MajorDB::find($data['id']);
            if ($major) {
                $major->name = $data['name'];
                $major->description = $data['description'];
                $major->color = $data['color'];
                $major->video = $data['video'];

                $locationData = $data['location'];
                $location = $major->location;

                $location->x = $locationData['x'];
                $location->y = $locationData['y'];
                $location->building = $locationData['building'];
                $location->link = $locationData['link'];

                if (!($major->save() && $location->save())) {
                    throw new Exception("HI 2");
                }
            } else {
                throw new Exception("HI 1");
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function addSkills($major_id, $skills)
    {
        DB::beginTransaction();
        try {
            foreach ($skills as $skill) {
                $newSkill = new Skill([
                    'skill' => $skill,
                    'major_id' => $major_id
                ]);
                if ($newSkill->save()) {
                } else {
                    unset($skill);
                    throw new Exception("");
                }
            }
            unset($skill);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function addInterests($major_id, $interests)
    {
        DB::beginTransaction();
        try {
            foreach ($interests as $interest) {
                $newInterest = new Interest([
                    'interest' => $interest,
                    'major_id' => $major_id
                ]);
                if ($newInterest->save()) {
                } else {
                    unset($interest);
                    throw new Exception("");
                }
            }
            unset($interest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function deleteSkills($skills_id)
    {
        DB::beginTransaction();
        try {
            foreach ($skills_id as $skill) {
                DB::delete('delete from skills where id = ?', [$skill]);
            }
            unset($skill);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function deleteInterests($interests_id)
    {
        DB::beginTransaction();
        try {
            foreach ($interests_id as $interest) {
                DB::delete('delete from interests where id = ?', [$interest]);
            }
            unset($interest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function updateSkills($skills)
    {
        DB::beginTransaction();
        try {
            foreach ($skills as $skill) {
                DB::update('update skills set skill = ? where id = ?', [$skill['skill'], $skill['id']]);
            }
            unset($skill);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function updateInterests($interests)
    {
        DB::beginTransaction();
        try {
            foreach ($interests as $interest) {
                DB::update('update interests set interest = ? where id = ?', [$interest['interest'], $interest['id']]);
            }
            unset($interest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function newArea($data)
    {
        DB::beginTransaction();
        try {
            $area = new Area($data);
            if (!$area->save()) {
                throw new Exception("");
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function updateArea($data)
    {
        DB::beginTransaction();
        try {
            $area = Area::find($data['id']);
            $area->area = $data['area'];
            $area->tasks = $data['tasks'];
            $area->subareas = $data['subareas'];
            if (!$area->save()) {
                throw new Exception("");
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }

    public function deleteArea($id)
    {
        DB::beginTransaction();
        try {
            DB::delete('delete from areas where id = ?', [$id]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return  $e;
        }
        return null;
    }
}
