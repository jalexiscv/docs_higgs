<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Logger extends BaseConfig
{
    // .. other properties

    public $threshold = 5; // originally 4 but changed to 5 to log the warnings from the deprecations
}
