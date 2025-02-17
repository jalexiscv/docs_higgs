<?php

use Higgs\Config\Factories;

$users = Factories::models('Blog\Models\UserModel', ['preferApp' => false]);
