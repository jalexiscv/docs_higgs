<?php

use Higgs\Config\Factories;

$conn  = db_connect('auth');
$users = Factories::models('UserModel', [], $conn);
