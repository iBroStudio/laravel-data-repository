<?php

use IBroStudio\DataRepository\ValueObjects\Periods\WeekPeriod;

it('can instantiate WeekPeriod object value', function () {
    expect(WeekPeriod::from(10))
        ->toBeInstanceOf(WeekPeriod::class);
});

it('can return DayPeriod object value with unit', function () {
    expect(
        WeekPeriod::from(1)->withUnit()
    )->toEqual('week')
        ->and(
            WeekPeriod::from(10)->withUnit()
        )->toEqual('10 weeks');
});
