<?php

namespace Config;

// ...

class Validation extends BaseConfig
{
    // ...

    public array $ruleSets = [
        \Higgs\Validation\CreditCardRules::class,
        \Higgs\Validation\FileRules::class,
        \Higgs\Validation\FormatRules::class,
        \Higgs\Validation\Rules::class,
    ];

    // ...
}
