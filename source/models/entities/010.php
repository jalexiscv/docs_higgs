<?php

namespace App\Entities;

use Higgs\Entity\Entity;

class User extends Entity
{
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
