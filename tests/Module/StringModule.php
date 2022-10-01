<?php

namespace App\Tests\Module;

use App\Router;

class StringModule
{
    public function __construct(Router $route)
    {
        $route->add('GET','/string', function() {
            return "a simple string";
        }, "app_string");
    }
}