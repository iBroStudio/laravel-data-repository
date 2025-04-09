<?php

namespace IBroStudio\DataRepository\ValueObjects\Periods;

use IBroStudio\DataRepository\ValueObjects\IntegerValueObject;

class YearPeriod extends IntegerValueObject
{
    public function withUnit(): string
    {
        return trans_choice(
            key: 'data-repository::periods.year',
            number: $this->value,
            replace: ['quantity' => $this->value]
        );
    }
}
