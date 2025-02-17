<?php

namespace App\Controllers;

use Higgs\Controller;

abstract class BaseController extends Controller
{
    // ...

    protected $helpers = ['html', 'text'];

    // ...
}
