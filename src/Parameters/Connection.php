<?php

namespace LumenRequestParser\Parameters;

use LumenRequestParser\Interfaces\ConnectionInterface;

class Connection implements ConnectionInterface
{
    protected $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
