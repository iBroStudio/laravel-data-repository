<?php

namespace IBroStudio\DataRepository\Tests\Support\DataObjects;

use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use Spatie\LaravelData\Data;

class WithEncryptableTextData extends Data
{
    public function __construct(
        public string $name,
        public EncryptableText $secret
    ) {}
}
