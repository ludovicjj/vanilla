<?php

namespace App\Tests\Framework;

use App\Framework\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    private Renderer $renderer;

    public function setUp(): void
    {
        $this->renderer = new Renderer();
    }

    public function testRenderDefaultPath(): void
    {
        $this->renderer->addPath( __DIR__.'/view');
        $content = $this->renderer->render('template');
        $this->assertEquals('hello world', $content);
    }

    public function testRenderWithNamespace(): void
    {
        $this->renderer->addPath( 'blog',__DIR__.'/view');
        $content = $this->renderer->render('@blog/template');
        $this->assertEquals('hello world', $content);
    }

    public function testRenderWithParameters(): void
    {
        $this->renderer->addPath( __DIR__.'/view');
        $content = $this->renderer->render('template_with_params', [
            'name' => 'john'
        ]);
        $this->assertEquals('hello john', $content);
    }

    public function testAddGlobalParameter(): void
    {
        $this->renderer->addPath( __DIR__.'/view');
        $this->renderer->addGlobal('name', 'john');
        $content = $this->renderer->render('template_with_params');
        $this->assertEquals('hello john', $content);
    }
}