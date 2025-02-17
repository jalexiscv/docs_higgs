<?php

use Higgs\Config\Factories;

class SomeOtherClass
{
    public function someFunction()
    {
        $users = Factories::models('UserModel');

        // ...
    }
}
