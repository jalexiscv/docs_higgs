<?php

$request = new \Higgs\HTTP\IncomingRequest(
    new \Config\App(),
    new \Higgs\HTTP\URI('http://example.com'),
    null,
    new \Higgs\HTTP\UserAgent()
);

$request->setLocale($locale);

$results = $this->withRequest($request)
    ->controller(\App\Controllers\ForumController::class)
    ->execute('showCategories');
