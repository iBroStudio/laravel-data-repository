<?php

namespace IBroStudio\DataRepository\Tests\Support\DataObjects;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use Spatie\LaravelData\Data;

class ReferableData extends Data
{
    public function __construct(
        public string $name,
        public EncryptableText $password,
        public Authentication $authentication,
    ) {}
}
