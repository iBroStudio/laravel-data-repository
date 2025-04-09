<?php

namespace IBroStudio\DataRepository\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

class EncryptableTextTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): string
    {
        /** @var \IBroStudio\DataRepository\ValueObjects\EncryptableText $value */
        return $value->value;
    }
}
