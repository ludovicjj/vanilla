<?php

namespace App\Blog;

use App\Framework\Renderer;
use App\Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

class BlobModule
{
    private $renderer;

    public function __construct(Router $router, Renderer $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('blog', __DIR__.'/template');
        $router->add('GET', '/blog', [$this, 'index'], 'blog_index');
        $router->add('GET', '/blog/[cSlug:slug]', [$this, 'show'], 'blog_show');
    }

    public function index(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@blog/index');
    }

    public function show(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@blog/show', [
            'slug' => $request->getAttribute('slug')
        ]);
    }
}