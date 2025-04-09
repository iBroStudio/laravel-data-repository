<?php

namespace IBroStudio\DataRepository\ValueObjects\Periods;

use IBroStudio\DataRepository\ValueObjects\IntegerValueObject;

class WeekPeriod extends IntegerValueObject
{
    public function withUnit(): string
    {
        return trans_choice(
            key: 'data-repository::periods.week',
            number: $this->value,
            replace: ['quantity' => $this->value]
        );
    }
}
