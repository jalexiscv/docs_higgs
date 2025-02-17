<?php

namespace Config;

use Higgs\Config\BaseConfig;
use Higgs\Session\Handlers\FileHandler;

class Session extends BaseConfig
{
    // ...
    public string $driver = 'Higgs\Session\Handlers\RedisHandler';

    // ...
    public string $savePath = 'tcp://localhost:6379';

    // ...
}
