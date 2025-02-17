<?php

namespace Config;

use Higgs\Config\BaseConfig;

class MySalesConfig extends BaseConfig
{
    public int $target        = 100;
    public string $campaign   = 'Winter Wonderland';
    public static $registrars = [
        '\App\Models\RegionalSales',
    ];
}
