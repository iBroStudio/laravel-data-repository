<?php

namespace IBroStudio\DataRepository\ValueObjects\Periods;

use IBroStudio\DataRepository\ValueObjects\IntegerValueObject;

class DayPeriod extends IntegerValueObject
{
    public function withUnit(): string
    {
        return trans_choice(
            key: 'data-repository::periods.day',
            number: $this->value,
            replace: ['quantity' => $this->value]
        );
    }
}
