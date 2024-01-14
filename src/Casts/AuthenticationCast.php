<?php

namespace IBroStudio\DataRepository\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class AuthenticationCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return $value['valueObject']::make(...$value['values']);
    }
}
