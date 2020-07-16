<?php

namespace Informatec\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'email';

    protected $fillable = [
        'email',
        'name',
        'password',
        'active'
    ];

    public function setPassword($password)
    {
        $this->update([
            'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 10])
        ]);
    }
}
