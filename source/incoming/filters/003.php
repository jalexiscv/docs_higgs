<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf' => \Higgs\Filters\CSRF::class,
    ];

    // ...
}
