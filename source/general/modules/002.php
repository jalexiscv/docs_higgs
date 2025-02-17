<?php

namespace Config;

use Higgs\Config\AutoloadConfig;

class Autoload extends AutoloadConfig
{
    // ...

    public $files = [
        'path/to/my/functions.php',
        'path/to/my/constants.php',
        'path/to/my/bootstrap.php',
    ];

    // ...
}
