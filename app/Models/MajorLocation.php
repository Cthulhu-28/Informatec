<?php

namespace Informatec\Models;

use Illuminate\Database\Eloquent\Model;

class MajorLocation extends Model
{
    protected $table = 'major_location';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = [];

    protected $fillable = [
        'id',
        'x',
        'y',
        'building',
        'link'
    ];
}
