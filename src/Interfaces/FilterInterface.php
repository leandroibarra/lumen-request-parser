<?php

namespace LumenRequestParser\Interfaces;

interface FilterInterface
{
    public function setField(string $field): void;
    public function getField(): string;

    public function setOperator(string $operator): void;
    public function getOperator(): string;

    public function setValue(string $value): void;
    public function getValue(): string;
}
