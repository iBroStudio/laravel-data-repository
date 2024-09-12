<?php

namespace IBroStudio\DataRepository\Tests\Support\DataObjects;

use Spatie\LaravelData\Data;

class NestedData extends Data
{
    public function __construct(
        public string $name,
        public WithEncryptableTextData $encryptableTextData,
    ) {}
}
