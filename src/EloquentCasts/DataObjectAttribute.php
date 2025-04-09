<?php

namespace IBroStudio\DataRepository\EloquentCasts;

use IBroStudio\DataRepository\ValueObjects\ValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DataObjectAttribute implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (isset($attributes[$key])) {

            if (is_subclass_of($attributes['class'], ValueObject::class)) {
                return $attributes['class']::from(...json_decode($value, true));
            }

            return $attributes['class']::from(json_decode($value, true));
        }

        return null;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! is_null($value)) {

            if (! $value instanceof $attributes['class']) {

                $value = $attributes['class']::from($value);
            }

            return $value->toJson();
        }

        return null;
    }
}
