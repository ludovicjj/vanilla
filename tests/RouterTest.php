<?php

namespace App\Tests;

use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use App\Router;

class RouterTest extends TestCase
{
    public function setUp(): void
    {
       $this->router = new Router();
    }

    public function testRouteMatchSuccess(): void
    {
        $request = new ServerRequest('GET', '/foo');
        $this->router->add('GET', "/foo", function() {return 'hello';}, 'app_foo');
        $route = $this->router->match($request);

        $this->assertInstanceOf(Router\Route::class, $route);
    }

    public function testRouteMatchFailWithInvalidPath(): void
    {
        $request = new ServerRequest('GET', '/bar');
        $this->router->add('GET', "/foo", function() {return 'hello';}, 'app_foo');
        $route = $this->router->match($request);

        $this->assertEquals(null, $route);
    }

    public function testRouteMatchFailWithInvalidMethod(): void
    {
        $request = new ServerRequest('POST', '/foo');
        $this->router->add('GET', "/foo", function() {return 'hello';}, 'app_foo');
        $route = $this->router->match($request);

        $this->assertEquals(null, $route);
    }

    public function testRouteMatchSuccessWithParameters(): void
    {
        $request = new ServerRequest('GET', '/foo/my-slug');
        $this->router->add('GET', "/foo/[cSlug:slug]", function() {return 'hello';}, 'app_foo');
        $route = $this->router->match($request);

        $this->assertInstanceOf(Router\Route::class, $route);
        $this->assertEquals('app_foo', $route->getName());
        $this->assertEquals(['slug' => 'my-slug'], $route->getParameters());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }

    public function testGenerateUrl(): void
    {
        $this->router->add('GET', "/foo/[cSlug:slug]", function() {return 'hello';}, 'app_foo');
        $uri = $this->router->generateUri('app_foo', ['slug' => 'my-slug']);
        $this->assertEquals('/foo/my-slug', $uri);
    }
}