<?php

use IBroStudio\DataRepository\ValueObjects\Periods\YearPeriod;

it('can instantiate', function () {
    expect(YearPeriod::make(10))
        ->toBeInstanceOf(YearPeriod::class);
});

it('can format number with unit', function () {
    expect(
        YearPeriod::make(1)->value()
    )->toEqual('year')
        ->and(
            YearPeriod::make(10)->value()
        )->toEqual('10 years');
});
