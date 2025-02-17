<?php

namespace Tests\Feature;

use Higgs\Test\CIUnitTestCase;
use Higgs\Test\DatabaseTestTrait;
use Higgs\Test\FeatureTestTrait;

class FooTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->myClassMethod();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->anotherClassMethod();
    }
}
