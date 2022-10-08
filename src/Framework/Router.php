<?php

namespace App\Framework;

use AltoRouter;
use App\Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    private AltoRouter $router;

    public function __construct()
    {
        $this->router = new AltoRouter();
    }

    public function add(string $method, string $path, callable $callable, string $name)
    {
        $this->router->addMatchTypes(['cSlug' => '[a-zA-Z\-]+']);
        $this->router->map($method, $path, $callable, $name);
    }

    public function match(ServerRequestInterface $request): ?Route
    {
        $matchResult = $this->router->match($request->getUri()->getPath(), $request->getMethod());

        if ($matchResult) {
            return new Route($matchResult['name'], $matchResult['target'], $matchResult['params']);
        }

        return null;
    }

    public function generateUri(string $name, array $parameters): string
    {
        return $this->router->generate($name, $parameters);
    }
}