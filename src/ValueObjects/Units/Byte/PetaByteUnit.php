<?php

namespace IBroStudio\DataRepository\ValueObjects\Units\Byte;

use ByteUnits\Metric;
use IBroStudio\DataRepository\Contracts\UnitValueContract;
use IBroStudio\DataRepository\Enums\ByteUnitEnum;

class PetaByteUnit extends ByteUnit implements UnitValueContract
{
    public static function from(mixed ...$values): static
    {
        return parent::from(Metric::petabytes(current($values)));
    }

    public static function unit(): ?string
    {
        return ByteUnitEnum::PB->getLabel();
    }
}
