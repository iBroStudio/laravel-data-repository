<?php

namespace IBroStudio\DataRepository\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

class AuthenticationTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): array
    {
        return [
            'valueObject' => $value::class,
            'values' => $value->toArray(),
        ];
    }
}
