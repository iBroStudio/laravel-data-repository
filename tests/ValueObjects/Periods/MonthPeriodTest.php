<?php

use IBroStudio\DataRepository\ValueObjects\Periods\MonthPeriod;

it('can instantiate', function () {
    expect(MonthPeriod::make(10))
        ->toBeInstanceOf(MonthPeriod::class);
});

it('can format number with unit', function () {
    expect(
        MonthPeriod::make(1)->value()
    )->toEqual('month')
        ->and(
            MonthPeriod::make(10)->value()
        )->toEqual('10 months');
});
