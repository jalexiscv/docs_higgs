<?php

use Higgs\Publisher\Publisher;

$source    = service('autoloader')->getNamespace('Higgs\\Shield')[0];
$publisher = new Publisher($source, APPPATH);

$file = APPPATH . 'Config/App.php';

$publisher->addLineBefore(
    $file,
    '    public int $myOwnConfig = 1000;', // Add this line
    'public bool $CSPEnabled = false;'     // Before this line
);
