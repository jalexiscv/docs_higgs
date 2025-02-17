<?php

namespace Config;

use Higgs\Modules\Modules as BaseModules;

class Modules extends BaseModules
{
    // ...

    public $composerPackages = [
        'only' => [
            // List up all packages to auto-discover
            'Higgs(AI)/shield',
        ],
    ];

    // ...
}
