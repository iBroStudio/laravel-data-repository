<?php

namespace IBroStudio\DataRepository\EloquentCasts;

use IBroStudio\DataRepository\ValueObjects\ValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ValueObjectCast implements CastsAttributes
{
    public function __construct(
        protected string $valueObjectClass,
        protected ?string $params = null,
    ) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): ?ValueObject
    {
        if (is_null($value)) {
            return null;
        }

        return $this->valueObjectClass::from($value, $this->params);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_array($value)) {
            return current($value);
        }

        if ($value instanceof ValueObject) {

            return $value->value;
        }

        return $value;
    }
}
