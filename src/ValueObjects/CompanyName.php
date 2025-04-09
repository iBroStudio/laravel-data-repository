<?php

namespace IBroStudio\DataRepository\ValueObjects;

use IBroStudio\DataRepository\Formatters\NameFormatter;

class CompanyName extends ValueObject
{
    public function __construct(mixed $value)
    {
        parent::__construct(
            NameFormatter::format($value)
        );
    }
}
