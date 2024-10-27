<?php

use IBroStudio\DataRepository\ValueObjects\Units\DecimalUnit;

it('can instantiate', function () {
    expect(DecimalUnit::make(10.46))
        ->toBeInstanceOf(DecimalUnit::class);
});

it('can format number with unit', function () {
    expect(
        DecimalUnit::make(10.00)->value()
    )->toEqual('10')
        ->and(
            DecimalUnit::make(10.58)->value()
        )->toEqual('10.58')
        ->and(
            DecimalUnit::make(10.50)->value()
        )->toEqual('10.5');
});

it('can retrieve unit alone', function () {
    expect(DecimalUnit::unit())
        ->toBeNull();
});
