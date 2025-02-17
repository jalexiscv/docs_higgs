<?php

use Higgs\Publisher\Publisher;

$source    = service('autoloader')->getNamespace('Higgs\\Shield')[0];
$publisher = new Publisher($source, APPPATH);

$file = APPPATH . 'Config/Auth.php';

$publisher->replace(
    $file,
    [
        'use Higgs\Config\BaseConfig;' . "\n" => '',
        'class App extends BaseConfig'              => 'class App extends \Some\Package\SomeConfig',
    ]
);
