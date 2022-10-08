<?php

namespace App\Framework;

class Renderer
{
    public array $paths = [];
    private array $global = [];

    const DEFAULT_NAMESPACE = '__MAIN';

    public function addPath(string $namespace, ?string $path = null)
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            // blog => 'vanilla/src/Blog/template'
            $this->paths[$namespace] = $path;
        }
    }

    public function render(string $view, array $parameters = [])
    {
        if ($this->hasNamespace($view)) {
            // @blog/index -> (str_replace(@blog)) -> vanilla/src/Blog/template/index.php
            $templatePath = $this->replaceNamespace($view) . '.php';
        } else {
            $templatePath = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        $renderer = $this;
        extract($this->global);
        extract($parameters);
        require($templatePath);
        return ob_get_clean();
    }

    public function addGlobal(string $key, mixed $value): void
    {
        $this->global[$key] = $value;
    }

    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }

    private function getNamespace(string $view): string
    {
        return substr($view, 1, (strpos($view,'/') - 1));
    }
}