<?php

use Higgs\Config\Factories;

$users = Factories::models('Blog\Models\UserModel');
// Or
$users = Factories::models(\Blog\Models\UserModel::class);
