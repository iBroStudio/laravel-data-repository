<?php

use IBroStudio\DataRepository\ValueObjects\Units\Byte\MegaByteUnit;

it('can instantiate', function () {
    expect(MegaByteUnit::make(10))
        ->toBeInstanceOf(MegaByteUnit::class);
});

it('can format number with unit', function () {
    expect(
        MegaByteUnit::make(10.00)->value()
    )->toEqual('10MB')
        ->and(
            MegaByteUnit::make(10.58)->value()
        )->toEqual('10.58MB')
        ->and(
            MegaByteUnit::make(10.50)->value()
        )->toEqual('10.5MB');
});

it('can retrieve unit alone', function () {
    expect(MegaByteUnit::unit())->toEqual('MB');
});
