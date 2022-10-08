<?php

namespace App\Framework;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Kernel
{
    private array $modules = [];

    private Router $router;

    /**
     * @param string[] $modules
     */
    public function __construct(array $modules = [])
    {
        $this->router = new Router();
        foreach ($modules as $module) {
            $this->modules[] = new $module($this->router);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();

        if (!empty($uri) && strlen($uri) !== 1 && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }

        $route = $this->router->match($request);

        if (!$route) {
            return new Response(404, [], '<h1>Uri fail to match with any routes</h1>');
        }
        foreach ($route->getParameters() as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }
        $response = call_user_func_array($route->getCallback(), [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('Excepted string or an instance of ResponseInterface');
        }
    }
}