<?php

namespace LumenRequestParser\Parameters;

use LumenRequestParser\Interfaces\ParameterInterface;

class Parameter implements ParameterInterface
{
    protected $field;
    protected $value;

    public function __construct(string $field, string $value)
    {
        $this->setField($field);
        $this->setValue($value);
    }

    public function setField(string $field): void
    {
        $this->field = $field;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
