<?php

namespace App\Controllers;

use Higgs\API\ResponseTrait;
use Higgs\Controller;

class Users extends Controller
{
    use ResponseTrait;

    public function createUser()
    {
        $model = new UserModel();
        $user  = $model->save($this->request->getPost());

        // Respond with 201 status code
        return $this->respondCreated();
    }
}
