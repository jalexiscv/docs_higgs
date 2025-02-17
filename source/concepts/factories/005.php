<?php

namespace Config;

use Higgs\Config\Factory as BaseFactory;
use Higgs\Filters\FilterInterface;

class Factory extends BaseFactory
{
    public $filters = [
        'instanceOf' => FilterInterface::class,
    ];
}
