<?php

namespace App\Models;

use Higgs\Model;

class MyModel extends Model
{
    protected $allowedFields = ['name', 'email', 'address'];
}
