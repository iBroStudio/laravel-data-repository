<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Name extends \MichaelRubel\ValueObjects\Collection\Complex\Name
{
    protected string|Stringable $value;

    public function value(): string
    {
        return Str::of((string) $this->value)
            ->lower()
            ->ucfirst()
            ->toString();
    }
}
