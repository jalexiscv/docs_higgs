<?php

namespace Tests;

use Higgs\HTTP\CURLRequest;
use Higgs\Test\CIUnitTestCase;
use Config\Services;

final class SomeTest extends CIUnitTestCase
{
    public function testSomething()
    {
        $curlrequest = $this->getMockBuilder(CURLRequest::class)
            ->onlyMethods(['request'])
            ->getMock();
        Services::injectMock('curlrequest', $curlrequest);

        // Do normal testing here....
    }
}
