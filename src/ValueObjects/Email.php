<?php

namespace IBroStudio\DataRepository\ValueObjects;

class Email extends \MichaelRubel\ValueObjects\Collection\Complex\Email
{
    public static function from(mixed ...$values): static
    {
        if (array_key_exists('email', $values)) {
            return static::make($values['email']);
        }

        return static::make(...$values);
    }
}
