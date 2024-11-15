<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class FirstName extends Name
{
    protected string|Stringable $value;

    public function value(): string
    {
        return Str::of($this->value)
            ->lower()
            ->ucfirst()
            ->toString();
    }
}
