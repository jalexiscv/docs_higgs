<?php

namespace Config;

use Higgs\Config\BaseService;

class Services extends BaseService
{
    public static function routes(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('routes');
        }

        return new \App\Libraries\RouteCollection(static::locator(), config(Modules::class), config(Routing::class));
    }

    // ...
}
