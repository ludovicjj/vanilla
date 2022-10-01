<?php

namespace App\Blog;

use App\Router;
use Psr\Http\Message\ServerRequestInterface;

class BlobModule
{
    public function __construct(Router $router)
    {
        $router->add('GET', '/blog', [$this, 'index'], 'blog_index');
        $router->add('GET', '/blog/[cSlug:slug]', [$this, 'show'], 'blog_show');
    }

    public function index(ServerRequestInterface $request): string
    {
        return '<h1>Welcome to blog</h1>';
    }

    public function show(ServerRequestInterface $request): string
    {
        return "<h1>Post: " .$request->getAttribute('slug')."</h1>" ;
    }
}