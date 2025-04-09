<?php

namespace IBroStudio\DataRepository\ValueObjects;

use IBroStudio\DataRepository\Formatters\LastNameFormatter;

class LastName extends ValueObject
{
    public function __construct(mixed $value)
    {
        parent::__construct(
            LastNameFormatter::format($value)
        );
    }
}
