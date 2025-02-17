<?php

$uri = new \Higgs\HTTP\URI('http://www.example.com?foo=bar&bar=baz&baz=foz');

// Leaves just the 'baz' variable
$uri->stripQuery('foo', 'bar');

// Leaves just the 'foo' variable
$uri->keepQuery('foo');
