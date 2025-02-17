<?php

namespace Config;

use Higgs\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    // ...
    public $development = [/* ... */];
    public $test        = [/* ... */];
    public $production  = [/* ... */];

    public function __construct()
    {
        // ...

        $this->defaultGroup = ENVIRONMENT;
    }
}
