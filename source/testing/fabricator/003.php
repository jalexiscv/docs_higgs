<?php

use App\Models\UserModel;
use Higgs\Test\Fabricator;

$model = new UserModel($testDbConnection);

$fabricator = new Fabricator($model);
