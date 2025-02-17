<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Filters extends BaseConfig
{
    public $methods = [
        'get'  => ['csrf'],
        'post' => ['csrf'],
    ];

    // ...
}
