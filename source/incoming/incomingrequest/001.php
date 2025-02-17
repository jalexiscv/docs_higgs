<?php

namespace App\Controllers;

use Higgs\Controller;

class UserController extends Controller
{
    public function index()
    {
        if ($this->request->isAJAX()) {
            // ...
        }
    }
}
