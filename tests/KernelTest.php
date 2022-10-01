<?php

namespace App\Tests;

use App\Kernel;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $kernel = new Kernel();
        $request = new ServerRequest('GET', '/test/');
        $response = $kernel->run($request);

        $this->assertContains('/test', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }
}