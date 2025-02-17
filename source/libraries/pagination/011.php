<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Pager extends BaseConfig
{
    public $templates = [
        'default_full'   => 'Higgs\Pager\Views\default_full',
        'default_simple' => 'Higgs\Pager\Views\default_simple',
        'front_full'     => 'App\Views\Pagers\foundation_full',
    ];

    // ...
}
