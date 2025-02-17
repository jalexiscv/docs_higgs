<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Filters extends BaseConfig
{
    // ...

    public array $methods = [
        'post' => ['invalidchars', 'csrf'],
        'get'  => ['csrf'],
    ];

    // ...
}
