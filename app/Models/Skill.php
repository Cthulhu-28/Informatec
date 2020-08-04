<?php

namespace Informatec\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';

    protected $primaryKey = 'id';

    public $incrementing = true;


    public $timestamps = [];

    protected $fillable = [
        'id',
        'skill',
        'major_id'
    ];
}
