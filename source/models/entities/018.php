<?php

namespace App\Entities;

use Higgs\Entity\Entity;

class MyEntity extends Entity
{
    // Specify the type for the field
    protected $casts = [
        'key' => 'base64',
    ];

    // Bind the type to the handler
    protected $castHandlers = [
        'base64' => Cast\CastBase64::class,
    ];
}

// ...

$entity->key = 'test'; // dGVzdA==
echo $entity->key;     // test
