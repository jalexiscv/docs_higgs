<?php

namespace Tests;

use Higgs\CLI\CLI;
use Higgs\Test\CIUnitTestCase;
use Higgs\Test\StreamFilterTrait;

final class SomeTest extends CIUnitTestCase
{
    use StreamFilterTrait;

    public function testSomeOutput(): void
    {
        CLI::write('first.');

        $this->assertSame("\nfirst.\n", $this->getStreamFilterBuffer());

        $this->resetStreamFilterBuffer();

        CLI::write('second.');

        $this->assertSame("second.\n", $this->getStreamFilterBuffer());
    }
}
