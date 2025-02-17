<?php

namespace App\Models;

use Higgs\Database\ConnectionInterface;

class UserModel
{
    protected $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }
}
