<?php

namespace IBroStudio\DataRepository\Formatters;

use IBroStudio\DataRepository\Contracts\Formatter;
use Illuminate\Support\Str;

class ByteFormatter implements Formatter
{
    public static function format(string $value): string
    {
        $unit = Str::substr($value, -2);

        return Str::of($value)
            ->chopEnd($unit)
            ->rtrim('0')
            ->chopEnd('.')
            ->append($unit)
            ->value();
    }
}
