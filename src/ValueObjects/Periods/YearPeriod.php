<?php

namespace IBroStudio\DataRepository\ValueObjects\Periods;

use IBroStudio\DataRepository\ValueObjects\Number;

class YearPeriod extends Number
{
    public function value(): string
    {
        return trans_choice(
            key: 'data-repository::periods.year',
            number: $this->asInteger(),
            replace: ['quantity' => $this->asInteger()]
        );
    }
}
