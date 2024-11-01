<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class CompanyName extends Name
{
    protected string|Stringable $value;

    public function value(): string
    {
        return Str::upper((string) $this->value);
    }
}
