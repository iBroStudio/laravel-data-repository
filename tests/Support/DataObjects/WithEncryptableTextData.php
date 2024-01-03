<?php

namespace IBroStudio\DataObjectsRepository\Tests\Support\DataObjects;

use IBroStudio\DataObjectsRepository\ValueObjects\EncryptableText;
use Spatie\LaravelData\Data;

class WithEncryptableTextData extends Data
{
    public function __construct(
        public string $name,
        public EncryptableText $secret
    ) {
    }
}
