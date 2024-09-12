<?php

namespace IBroStudio\DataRepository\ValueObjects;

class TaxNumber extends \MichaelRubel\ValueObjects\Collection\Complex\TaxNumber
{
    public static function from(mixed ...$values): static
    {
        if (array_key_exists('fullTaxNumber', $values)) {
            return static::make($values['fullTaxNumber']);
        }

        return static::make(...$values);
    }
}
