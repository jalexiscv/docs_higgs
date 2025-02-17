<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Format extends BaseConfig
{
    public $supportedResponseFormats = [
        'application/json',
        'application/xml',
    ];

    // ...
}
