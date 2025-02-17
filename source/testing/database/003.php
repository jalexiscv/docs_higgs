<?php

namespace App\Database;

use Higgs\Test\CIUnitTestCase;
use Higgs\Test\DatabaseTestTrait;

class MyTests extends CIUnitTestCase
{
    use DatabaseTestTrait;

    // For Migrations
    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'Tests\Support';

    // For Seeds
    protected $seedOnce = false;
    protected $seed     = 'TestSeeder';
    protected $basePath = 'path/to/database/files';

    // ...
}
