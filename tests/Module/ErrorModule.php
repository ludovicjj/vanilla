<?php

namespace App\Tests\Module;

use App\Router;

class ErrorModule
{
    public function __construct(Router $route)
    {
        $route->add('GET','/error', function() {
            return new \stdClass();
        }, "app_error");
    }
}