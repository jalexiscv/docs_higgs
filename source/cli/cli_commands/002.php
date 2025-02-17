<?php

namespace App\Commands;

use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;

class AppInfo extends BaseCommand
{
    protected $group       = 'Demo';
    protected $name        = 'app:info';
    protected $description = 'Displays basic application information.';

    public function run(array $params)
    {
        // ...
    }
}
