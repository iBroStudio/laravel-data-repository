<?php

namespace IBroStudio\DataRepository\ValueObjects\Units;

use IBroStudio\DataRepository\Contracts\UnitValueContract;
use IBroStudio\DataRepository\ValueObjects\Number;

class IntegerUnit extends Number implements UnitValueContract
{
    public function value(): string
    {
        return (string) $this->asInteger();
    }

    public static function unit(): ?string
    {
        return null;
    }
}
