<?php

$mock = mock(\Higgs\Cache\CacheFactory::class);
// Never cache any items during this test.
$mock->bypass();
