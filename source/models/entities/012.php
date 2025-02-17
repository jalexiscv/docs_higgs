<?php

namespace App\Entities;

use Higgs\Entity\Entity;

class User extends Entity
{
    protected $casts = [
        'is_banned'          => 'boolean',
        'is_banned_nullable' => '?boolean',
    ];
}
