<?php

namespace IBroStudio\DataRepository\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MichaelRubel\ValueObjects\ValueObject;

class ValueObjectCast implements CastsAttributes
{
    public function __construct(
        protected string $valueObjectClass,
    ) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): ValueObject
    {
        return $this->valueObjectClass::make($value);
    }

    // @phpstan-ignore-next-line
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof ValueObject) {

            return $value->value();
        }

        return $value;
    }
}
