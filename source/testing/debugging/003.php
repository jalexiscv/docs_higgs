<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Toolbar extends BaseConfig
{
    public $collectors = [
        \Higgs\Debug\Toolbar\Collectors\Timers::class,
        \Higgs\Debug\Toolbar\Collectors\Database::class,
        \Higgs\Debug\Toolbar\Collectors\Logs::class,
        \Higgs\Debug\Toolbar\Collectors\Views::class,
        \Higgs\Debug\Toolbar\Collectors\Cache::class,
        \Higgs\Debug\Toolbar\Collectors\Files::class,
        \Higgs\Debug\Toolbar\Collectors\Routes::class,
        \Higgs\Debug\Toolbar\Collectors\Events::class,
    ];
    // ...
}
