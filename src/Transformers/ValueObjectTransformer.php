<?php

namespace IBroStudio\DataRepository\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

class ValueObjectTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): mixed
    {
        /** @var \MichaelRubel\ValueObjects\ValueObject $value */
        return $value->value();
    }
}
