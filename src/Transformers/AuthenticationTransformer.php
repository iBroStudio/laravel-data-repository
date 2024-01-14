<?php

namespace IBroStudio\DataRepository\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class AuthenticationTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value): array
    {
        /** @var \IBroStudio\DataRepository\Contracts\Authentication $value */
        return [
            'valueObject' => $value::class,
            'values' => $value->toArray(),
        ];
    }
}
