<?php

use Higgs\Cookie\Cookie;
use Higgs\Cookie\CookieStore;

$store = new CookieStore([
    new Cookie('login_token'),
    new Cookie('remember_token'),
]);

$store->dispatch(); // After dispatch, the collection is now empty.
