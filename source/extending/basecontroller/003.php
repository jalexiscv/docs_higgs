<?php

namespace App\Controllers;

use Higgs\Controller;

abstract class BaseController extends Controller
{
    // ...

    /**
     * @var \Higgs\Session\Session;
     */
    protected $session;

    public function initController(/* ... */)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();
    }
}
