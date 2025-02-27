<?php

namespace App\Entities;

use Higgs\Entity\Entity;

class User extends Entity
{
    protected $casts = [
        'options'        => 'array',
        'options_object' => 'json',
        'options_array'  => 'json-array',
    ];
}
