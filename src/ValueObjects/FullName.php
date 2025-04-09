<?php

namespace IBroStudio\DataRepository\ValueObjects;

use IBroStudio\DataRepository\Formatters\LastNameFormatter;
use IBroStudio\DataRepository\Formatters\NameFormatter;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FullName extends ValueObject
{
    public readonly mixed $firstname;

    public readonly mixed $lastname;

    public function __construct(mixed $value)
    {
        $parts = Str::of($value)
            ->split('/\s/');

        $firstnames = new Collection;

        $this->lastname = LastNameFormatter::format($parts->pop());

        $parts->each(function (string $part) use (&$firstnames) {
            $firstnames->push(NameFormatter::format($part));
        });

        $this->firstname = $firstnames->join(' ');

        parent::__construct($this->firstname.' '.$this->lastname);
    }
}
