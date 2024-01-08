<?php

namespace LumenRequestParser\Interfaces;

interface ConnectionInterface
{
    public function setName(string $name): void;
    public function getName(): string;
}
