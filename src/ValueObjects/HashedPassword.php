<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Facades\Hash;

class HashedPassword extends ValueObject
{
    public function __construct(mixed $value)
    {
        parent::__construct(
            Hash::make($value)
        );
    }
}
