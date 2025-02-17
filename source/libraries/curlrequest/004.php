<?php

$client = new \Higgs\HTTP\CURLRequest(
    new \Config\App(),
    new \Higgs\HTTP\URI(),
    new \Higgs\HTTP\Response(new \Config\App()),
    $options
);
