<?php

namespace App\Models;

use Higgs\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $allowedFields = [
        'username', 'email', 'password',
    ];
    protected $returnType    = \App\Entities\User::class;
    protected $useTimestamps = true;
}
