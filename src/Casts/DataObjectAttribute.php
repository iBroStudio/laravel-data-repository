<?php

namespace IBroStudio\DataObjectsRepository\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DataObjectAttribute implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        if (isset($attributes[$key])) {

            return $attributes['class']::from(
                json_decode($value, true)
            );
        }

        return null;
    }

    public function set($model, $key, $value, $attributes)
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
