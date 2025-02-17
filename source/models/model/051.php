<?php

namespace App\Models;

use Higgs\Model;

class MyModel extends Model
{
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
}
