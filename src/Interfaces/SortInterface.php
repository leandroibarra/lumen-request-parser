<?php

namespace LumenRequestParser\Interfaces;

interface SortInterface
{
    public function setField(string $field): void;
    public function getField(): string;

    public function setDirection(string $direction): void;
    public function getDirection(): string;
}
