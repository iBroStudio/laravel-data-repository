<?php

namespace IBroStudio\DataRepository\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MichaelRubel\ValueObjects\ValueObject;

class ValueObjectCast implements CastsAttributes
{
    public function __construct(
        protected string $valueObjectClass,
        protected ?string $params = null,
    ) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): ValueObject
    {
        return $this->valueObjectClass::make($value, $this->params);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value instanceof ValueObject) {

            return $value->value();
        }

        return $value;
    }
}
