<?php

namespace IBroStudio\DataRepository\ValueObjects\Units;

use IBroStudio\DataRepository\Contracts\UnitValueContract;
use IBroStudio\DataRepository\ValueObjects\IntegerValueObject;

class EmailUnit extends IntegerValueObject implements UnitValueContract
{
    public function withUnit(): string
    {
        return trans_choice(
            key: 'data-repository::units.email',
            number: $this->value,
            replace: ['quantity' => $this->value]
        );
    }

    public static function unit(): ?string
    {
        return trans_choice(
            key: 'data-repository::units.email',
            number: 2,
            replace: ['quantity' => '']
        );
    }
}
