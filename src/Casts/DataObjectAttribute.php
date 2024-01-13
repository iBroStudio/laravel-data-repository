<?php

namespace IBroStudio\DataRepository\Casts;

use IBroStudio\ModelDisk\DataObjects\FtpConfig;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use MichaelRubel\ValueObjects\ValueObject;

class DataObjectAttribute implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        if (isset($attributes[$key])) {

            if (is_subclass_of($attributes['class'], ValueObject::class)) {
                return $attributes['class']::from(...json_decode($value, true));
            }

            return $attributes['class']::from(json_decode($value, true));
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
