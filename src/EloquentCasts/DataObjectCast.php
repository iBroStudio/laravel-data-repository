<?php

namespace IBroStudio\DataRepository\EloquentCasts;

use IBroStudio\DataRepository\Exceptions\DataObjectCastException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

class DataObjectCast implements CastsAttributes
{
    public function __construct(protected ?string $dataClass = null)
    {
        if (! is_null($this->dataClass) && ! is_subclass_of($this->dataClass, Data::class)) {
            throw new DataObjectCastException(given: $this->dataClass, expected: Data::class);
        }
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_int($value)) {
            // @phpstan-ignore-next-line
            return $model->data_repository()->whereId($value)->values();
        }

        return $value;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! is_null($value)
            && ! is_int($value)
            && ! is_null($this->dataClass)
        ) {

            if (is_array($value)) {
                return $this->dataClass::fromConverters($value);
            }

            if (! is_a($value, $this->dataClass)) {
                throw new DataObjectCastException(given: $key, expected: $this->dataClass);
            }
        }

        return $value;
    }
}
