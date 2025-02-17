<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Filters extends BaseConfig
{
    // ...

    public $globals = [
        'before' => [
            // 'honeypot',
            'csrf',
        ],
    ];

    // ...
}
