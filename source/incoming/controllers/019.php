<?php

namespace App\Controllers;

class Products extends BaseController
{
    public function _remap($method, ...$params)
    {
        $method = 'process_' . $method;

        if (method_exists($this, $method)) {
            return $this->{$method}(...$params);
        }

        throw \Higgs\Exceptions\PageNotFoundException::forPageNotFound();
    }
}
