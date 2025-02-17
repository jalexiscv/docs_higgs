<?php

namespace Config;

use Higgs\Config\BaseConfig;
use Higgs\Session\Handlers\FileHandler;

class Session extends BaseConfig
{
    // ...
    public ?string $DBGroup = 'groupName';
}
