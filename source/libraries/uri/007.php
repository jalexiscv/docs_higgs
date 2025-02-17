<?php

use Higgs\HTTP\URI;

$uriString = URI::createURIString($scheme, $authority, $path, $query, $fragment);

// Creates: http://exmample.com/some/path?foo=bar#first-heading
echo URI::createURIString('http', 'example.com', 'some/path', 'foo=bar', 'first-heading');
