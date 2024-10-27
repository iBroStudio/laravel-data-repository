<?php

namespace IBroStudio\DataRepository\ValueObjects\Units\Byte;

use ByteUnits\Metric;
use IBroStudio\DataRepository\Contracts\UnitValueContract;

class GigaByteUnit extends ByteUnit implements UnitValueContract
{
    public static function make(mixed ...$values): static
    {
        return new static(
            Metric::gigabytes($values[0])
        );
    }

    public static function unit(): ?string
    {
        return 'GB';
    }
}
