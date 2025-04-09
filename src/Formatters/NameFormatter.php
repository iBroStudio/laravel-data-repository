<?php

namespace IBroStudio\DataRepository\Formatters;

use IBroStudio\DataRepository\Contracts\Formatter;
use Illuminate\Support\Str;

class NameFormatter implements Formatter
{
    public static function format(string $value): string
    {
        return Str::of($value)
            ->squish()
            ->title()
            ->value();
    }
}
