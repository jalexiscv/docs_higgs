<?php

$logger = new \Higgs\Log\Handlers\FileHandler();

$results = $this->withResponse($response)
    ->withLogger($logger)
    ->controller(\App\Controllers\ForumController::class)
    ->execute('showCategories');
