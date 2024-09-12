<?php

namespace IBroStudio\DataRepository\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MichaelRubel\ValueObjects\ValueObject;

class DataObjectAttribute implements CastsAttributes
{
    // @phpstan-ignore-next-line
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if (isset($attributes[$key])) {

            if (is_subclass_of($attributes['class'], ValueObject::class)) {
                return $attributes['class']::from(...json_decode($value, true));
            }

            return $attributes['class']::from(json_decode($value, true));
        }

        return null;
    }

    // @phpstan-ignore-next-line
    public function set(Model $model, string $key, mixed $value, array $attributes)
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
