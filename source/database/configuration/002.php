<?php

namespace Config;

use Higgs\Database\Config;

class Database extends Config
{
    // ...

    // OCI8
    public array $default = [
        'DSN' => '//localhost/XE',
        // ...
    ];

    // ...
}
