<?php

namespace Config;

use Higgs\Modules\Modules as BaseModules;

class Modules extends BaseModules
{
    // ...

    public $composerPackages = [
        'exclude' => [
            // List up packages to exclude.
            'pestphp/pest',
        ],
    ];

    // ...
}
