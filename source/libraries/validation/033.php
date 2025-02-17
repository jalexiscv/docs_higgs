<?php

namespace Config;

use Higgs\Config\BaseConfig;
use Higgs\Validation\CreditCardRules;
use Higgs\Validation\FileRules;
use Higgs\Validation\FormatRules;
use Higgs\Validation\Rules;

class Validation extends BaseConfig
{
    // ...

    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    // ...
}
