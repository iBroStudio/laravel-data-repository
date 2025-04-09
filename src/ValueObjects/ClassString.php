<?php

namespace IBroStudio\DataRepository\ValueObjects;

class ClassString extends ValueObject
{
    public function classExists(): bool
    {
        return class_exists($this->value);
    }

    public function interfaceExists(): bool
    {
        return interface_exists($this->value);
    }

    public function instantiate(array $parameters = []): object
    {
        return app($this->value, $parameters);
    }

    public function instantiateWith(array $parameters): object
    {
        return $this->instantiate($parameters);
    }
}
