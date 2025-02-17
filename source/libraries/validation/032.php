<?php

namespace Config;

// ...

class Validation extends BaseConfig
{
    // ...

    public array $templates = [
        'list'    => 'Higgs\Validation\Views\list',
        'single'  => 'Higgs\Validation\Views\single',
        'my_list' => '_errors_list',
    ];

    // ...
}
