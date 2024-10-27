<?php

namespace IBroStudio\DataRepository\ValueObjects\Units;

use IBroStudio\DataRepository\Contracts\UnitValueContract;
use IBroStudio\DataRepository\ValueObjects\Number;

class EmailUnit extends Number implements UnitValueContract
{
    public function value(): string
    {
        return trans_choice(
            key: 'data-repository::units.email',
            number: $this->asInteger(),
            replace: ['quantity' => $this->asInteger()]
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
