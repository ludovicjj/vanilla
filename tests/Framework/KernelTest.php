<?php

namespace App\Tests\Framework;

use App\Blog\BlobModule;
use App\Framework\Kernel;
use App\Framework\Renderer;
use App\Tests\Framework\Module\ErrorModule;
use App\Tests\Framework\Module\ResponseModule;
use App\Tests\Framework\Module\StringModule;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

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

    public function testBlogModule(): void
    {
        $renderer = new Renderer();
        $renderer->addPath(dirname(__DIR__).'/../template');
        $kernel = new Kernel([
            BlobModule::class
        ], ['renderer' => $renderer]);

        $request = new ServerRequest('GET', '/blog');
        $response = $kernel->run($request);
        $this->assertEquals(200, $response->getStatusCode());

        $request = new ServerRequest('GET', '/blog/hello-world');
        $response = $kernel->run($request);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testExceptionModuleResponse(): void
    {
        $kernel = new Kernel([
            ErrorModule::class
        ]);

        $request = new ServerRequest('GET', '/error');
        $this->expectException(\Exception::class);
        $kernel->run($request);

    }

    public function testConvertStringToResponseObject(): void
    {
        $kernel = new Kernel([
            StringModule::class
        ]);

        $request = new ServerRequest('GET', '/string');
        $response = $kernel->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('a simple string', (string)$response->getBody());
    }

    public function testResponseModule(): void
    {
        $kernel = new Kernel([
            ResponseModule::class
        ]);

        $request = new ServerRequest('GET', '/response');
        $response = $kernel->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('a simple response', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRunWithInvalidRequestUri(): void
    {
        $kernel = new Kernel([]);

        $request = new ServerRequest('GET', '/foo');
        $response = $kernel->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }
}