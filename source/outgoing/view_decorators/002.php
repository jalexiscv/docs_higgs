<?php

namespace Config;

use Higgs\Config\View as BaseView;

class View extends BaseView
{
    public array $decorators = [
        'App\Views\Decorators\MyDecorator',
    ];

    // ...
}
