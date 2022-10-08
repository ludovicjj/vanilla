<?php

namespace App\Tests\Framework\Module;

use App\Framework\Router;

class ErrorModule
{
    public function __construct(Router $route)
    {
        $route->add('GET','/error', function() {
            return new \stdClass();
        }, "app_error");
    }
}