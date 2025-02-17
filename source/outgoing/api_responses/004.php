<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Format extends BaseConfig
{
    public $formatters = [
        'application/json' => \Higgs\Format\JSONFormatter::class,
        'application/xml'  => \Higgs\Format\XMLFormatter::class,
    ];

    // ...
}
