<?php

namespace App\Controllers;

use Higgs\RESTful\ResourceController;

class Photos extends ResourceController
{
    protected $modelName = 'App\Models\Photos';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // ...
}
