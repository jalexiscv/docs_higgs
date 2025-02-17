<?php

namespace Config;

use Higgs\Config\BaseService;

class Services extends BaseService
{
    // ...

    public static function routes($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('routes');
        }

        return new \App\Router\MyRouteCollection(static::locator(), config('Modules'));
    }
}
