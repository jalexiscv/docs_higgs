<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Filters extends BaseConfig
{
    // ...

    public array $globals = [
        'before' => [
            'csrf',
        ],
        'after' => [],
    ];

    // ...
}
