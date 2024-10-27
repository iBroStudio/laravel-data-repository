<?php

use IBroStudio\DataRepository\ValueObjects\Periods\DayPeriod;

it('can instantiate', function () {
    expect(DayPeriod::make(10))
        ->toBeInstanceOf(DayPeriod::class);
});

it('can format number with unit', function () {
    expect(
        DayPeriod::make(1)->value()
    )->toEqual('day')
        ->and(
            DayPeriod::make(10)->value()
        )->toEqual('10 days');
});
