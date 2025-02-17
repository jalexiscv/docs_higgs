<?php

namespace Config;

use Higgs\Database\Config;

class Database extends Config
{
    // ...

    public array $default = [
        'DSN' => 'DBDriver://username:password@hostname:port/database',
        // ...
    ];

    // ...
}
