<?php

namespace Config;

use Higgs\Config\BaseConfig;

class Logger extends BaseConfig
{
    public $handlers = [
        // File Handler
        'Higgs\Log\Handlers\FileHandler' => [
            'handles' => ['critical', 'alert', 'emergency', 'debug', 'error', 'info', 'notice', 'warning'],
        ],
    ];

    // ...
}
