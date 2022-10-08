<?php

namespace App\Tests\Framework\Module;

use App\Framework\Router;

class StringModule
{
    public function __construct(Router $route)
    {
        $route->add('GET','/string', function() {
            return "a simple string";
        }, "app_string");
    }
}