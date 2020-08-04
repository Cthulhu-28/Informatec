<?php

namespace Informatec\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $table = 'interests';

    protected $primaryKey = 'id';

    public $incrementing = true;


    public $timestamps = [];

    protected $fillable = [
        'id',
        'interest',
        'major_id'
    ];
}
