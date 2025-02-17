<?php

namespace App\Filters;

use Higgs\Filters\FilterInterface;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;

class MyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = service('auth');

        if (! $auth->isLoggedIn()) {
            return redirect()->to(site_url('login'));
        }
    }
}
