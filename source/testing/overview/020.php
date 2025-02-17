<?php

namespace Tests;

use Higgs\CLI\CLI;
use Higgs\Test\CIUnitTestCase;
use Higgs\Test\Filters\CITestStreamFilter;

final class SomeTest extends CIUnitTestCase
{
    public function testSomeOutput(): void
    {
        CITestStreamFilter::registration();
        CITestStreamFilter::addOutputFilter();

        CLI::write('first.');

        CITestStreamFilter::removeOutputFilter();
    }
}
