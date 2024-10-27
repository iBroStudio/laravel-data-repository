<?php

namespace IBroStudio\DataRepository\ValueObjects\Units\Byte;

use ByteUnits\Metric;
use IBroStudio\DataRepository\Contracts\UnitValueContract;

class PetaByteUnit extends ByteUnit implements UnitValueContract
{
    public static function make(mixed ...$values): static
    {
        return new static(
            Metric::petabytes($values[0])
        );
    }

    public static function unit(): ?string
    {
        return 'PB';
    }
}
