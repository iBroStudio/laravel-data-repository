<?php

use IBroStudio\DataRepository\ValueObjects\Units\Byte\TeraByteUnit;

it('can instantiate', function () {
    expect(TeraByteUnit::make(10))
        ->toBeInstanceOf(TeraByteUnit::class);
});

it('can format number with unit', function () {
    expect(
        TeraByteUnit::make(10.00)->value()
    )->toEqual('10TB')
        ->and(
            TeraByteUnit::make(10.58)->value()
        )->toEqual('10.58TB')
        ->and(
            TeraByteUnit::make(10.50)->value()
        )->toEqual('10.5TB');
});

it('can retrieve unit alone', function () {
    expect(TeraByteUnit::unit())->toEqual('TB');
});
