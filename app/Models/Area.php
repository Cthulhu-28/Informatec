<?php

namespace Informatec\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';

    protected $primaryKey = 'id';

    public $incrementing = true;


    public $timestamps = [];

    protected $fillable = [
        'id',
        'area',
        'tasks',
        'subareas',
        'major_id'
    ];
}
