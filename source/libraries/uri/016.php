<?php

$uri = new \Higgs\HTTP\URI('http://www.example.com/some/path');

echo $uri->getPath();                            // '/some/path'
echo $uri->setPath('/another/path')->getPath();  // '/another/path'
