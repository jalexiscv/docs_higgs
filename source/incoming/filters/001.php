<?php

namespace App\Filters;

use Higgs\Filters\FilterInterface;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;

class MyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
