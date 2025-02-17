<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Generators extends BaseConfig
{
    public array $views = [
        // ..
        'make:awesome-command' => 'App\Commands\Generators\Views\awesomecommand.tpl.php',
    ];
}
