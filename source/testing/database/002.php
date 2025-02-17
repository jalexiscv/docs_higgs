<?php

namespace App\Database;

use Higgs\Test\CIUnitTestCase;
use Higgs\Test\DatabaseTestTrait;

class MyTests extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        // Do something here....
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Do something here....
    }
}
