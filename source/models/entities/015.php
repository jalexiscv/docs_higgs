<?php

namespace App\Entities;

use Higgs\Entity\Entity;

class Widget extends Entity
{
    protected $casts = [
        'colors' => 'csv',
    ];
}
