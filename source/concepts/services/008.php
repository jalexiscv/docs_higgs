<?php

namespace Config;

use Higgs\Config\BaseService;

class Services extends BaseService
{
    // ...

    public static function renderer($viewPath = APPPATH . 'views/')
    {
        return new \Higgs\View\View($viewPath);
    }
}
