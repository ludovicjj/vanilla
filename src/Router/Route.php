<?php

namespace App\Router;

class Route
{
    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var callable $callback
     */
    private $callback;

    /**
     * @var array $parameters
     */
    private array $parameters;

    public function __construct(
        string $name,
        callable $callback,
        array $parameters
    )
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @return string[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}