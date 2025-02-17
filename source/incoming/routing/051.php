<?php

// In app/Config/Routing.php
use Higgs\Config\Routing as BaseRouting;

// ...
class Routing extends BaseRouting
{
    // ...
    public ?string $override404 = 'App\Errors::show404';
    // ...
}
