<?php

namespace Informatec\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'majors';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';


    public $timestamps = [];

    protected $fillable = [
        'id',
        'name',
        'description',
        'color',
        'video',
        'status',
    ];

    public function location()
    {
        return $this->hasOne('Informatec\Models\MajorLocation', 'id', 'id');
    }

    public function skills()
    {
        return $this->hasMany('Informatec\Models\Skill', 'major_id', 'id');
    }

    public function interests()
    {
        return $this->hasMany('Informatec\Models\Interest', 'major_id', 'id');
    }

    public function areas()
    {
        return $this->hasMany('Informatec\Models\Area', 'major_id', 'id');
    }
}
