<?php

namespace Config;

use Higgs\Database\Config;

class Database extends Config
{
    // ...

    // Postgre
    public array $default = [
        'DSN' => 'Postgre://username:password@hostname:5432/database?charset=utf8&connect_timeout=5&sslmode=1',
        // ...
    ];

    // ...
}
