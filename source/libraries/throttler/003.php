<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Filters extends BaseConfig
{
    public $aliases = [
        // ...
        'throttle' => \App\Filters\Throttle::class,
    ];

    // ...
}
