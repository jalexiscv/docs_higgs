<?php

namespace App\Controllers;

use Higgs\Test\CIUnitTestCase;
use Higgs\Test\ControllerTestTrait;
use Higgs\Test\DatabaseTestTrait;

class ForumControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    public function testShowCategories()
    {
        $result = $this->withURI('http://example.com/categories')
            ->controller(ForumController::class)
            ->execute('showCategories');

        $this->assertTrue($result->isOK());
    }
}
