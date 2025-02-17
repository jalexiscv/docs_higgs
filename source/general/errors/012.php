<?php

namespace Config;

use Higgs\Config\BaseConfig;
use Psr\Log\LogLevel;

class Exceptions extends BaseConfig
{
    // ... other properties

    public bool $logDeprecations       = true;
    public string $deprecationLogLevel = LogLevel::WARNING; // this should be one of the log levels supported by PSR-3
}
