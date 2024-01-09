<?php

namespace LumenRequestParser\Interfaces;

interface ParameterInterface
{
    public function setField(string $field): void;
    public function getField(): string;

    public function setValue(string $value): void;
    public function getValue(): string;
}
