<?php

namespace App\Models;

use Higgs\Test\CIUnitTestCase;

final class UserModelTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // Do not forget

        helper('text');
    }

    // ...
}
