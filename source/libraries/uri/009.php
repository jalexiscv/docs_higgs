<?php

$uri = new \Higgs\HTTP\URI('ftp://user:password@example.com:21/some/path');

echo $uri->getAuthority();  // user@example.com:21
