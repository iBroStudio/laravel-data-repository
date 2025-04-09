<?php

namespace IBroStudio\DataRepository\DataCasts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class AuthenticationCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
    {
        return $value['valueObject']::from(...$value['values']);
    }
}
