<?php

$uri = new \Higgs\HTTP\URI('http://www.example.com/some/path');

echo $uri->getHost();   // www.example.com
echo $uri->setHost('anotherexample.com')->getHost();    // anotherexample.com
