<?php

use IBroStudio\DataRepository\ValueObjects\Periods\WeekPeriod;

it('can instantiate', function () {
    expect(WeekPeriod::make(10))
        ->toBeInstanceOf(WeekPeriod::class);
});

it('can format number with unit', function () {
    expect(
        WeekPeriod::make(1)->value()
    )->toEqual('week')
        ->and(
            WeekPeriod::make(10)->value()
        )->toEqual('10 weeks');
});
