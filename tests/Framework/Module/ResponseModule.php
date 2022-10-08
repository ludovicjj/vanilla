<?php

namespace App\Tests\Framework\Module;

use App\Framework\Router;
use Nyholm\Psr7\Response;

class ResponseModule
{
    public function __construct(Router $route)
    {
        $route->add('GET','/response', function() {
            return new Response(200, [], 'a simple response');
        }, "app_response");
    }
}