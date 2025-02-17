<?php

namespace App\Filters;

use Higgs\Test\CIUnitTestCase;
use Higgs\Test\FilterTestTrait;

final class FooFilterTest extends CIUnitTestCase
{
    use FilterTestTrait;

    protected function testUnauthorizedAccessRedirects()
    {
        $caller = $this->getFilterCaller('permission', 'before');
        $result = $caller('MayEditWidgets');

        $this->assertInstanceOf('Higgs\HTTP\RedirectResponse', $result);
    }
}
