<?php

namespace IBroStudio\DataObjectsRepository\Casts;

use IBroStudio\DataObjectsRepository\ValueObjects\EncryptableText;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class EncryptedTextCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return EncryptableText::make($value['value']);
    }
}
