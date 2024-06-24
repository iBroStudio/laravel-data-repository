<?php

namespace IBroStudio\DataRepository\Tests\Support\DataObjects;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\DataObjects\DataRepository;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

class ReferableData extends DataRepository
{
    public function __construct(
        public string $name,
        public EncryptableText $password,
        public Authentication $authentication,
    ) {}
}
