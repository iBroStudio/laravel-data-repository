<?php

namespace IBroStudio\DataRepository\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DataObjectCast implements CastsAttributes
{
    // @phpstan-ignore-next-line
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        // @phpstan-ignore-next-line
        return $model->data_repository()->whereId($value)->values();
    }

    // @phpstan-ignore-next-line
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        return $value;
    }
}
