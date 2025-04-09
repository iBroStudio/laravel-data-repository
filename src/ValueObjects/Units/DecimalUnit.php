<?php

namespace IBroStudio\DataRepository\ValueObjects\Units;

use IBroStudio\DataRepository\Contracts\UnitValueContract;
use IBroStudio\DataRepository\ValueObjects\FloatValueObject;

class DecimalUnit extends FloatValueObject implements UnitValueContract
{
    public function withUnit(): string
    {
        return (string) $this->value;
    }

    public static function unit(): ?string
    {
        return null;
    }
}
