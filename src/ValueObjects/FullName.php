<?php

namespace IBroStudio\DataRepository\ValueObjects;

class FullName extends \MichaelRubel\ValueObjects\Collection\Complex\FullName
{
    public static function from(mixed ...$values): static
    {
        if (array_key_exists('fullName', $values)) {
            return static::make($values['fullName']);
        }

        return static::make(...$values);
    }
}
