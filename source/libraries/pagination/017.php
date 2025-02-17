<?php

namespace App\Models;

use Higgs\Model;

class UserModel extends Model
{
    // ...

    public function banned()
    {
        $this->builder()->where('ban', 1);

        return $this; // This will allow the call chain to be used.
    }
}
