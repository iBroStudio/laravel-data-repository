<?php

use IBroStudio\DataRepository\ValueObjects\Units\Byte\KiloByteUnit;

it('can instantiate', function () {
    expect(KiloByteUnit::make(10))
        ->toBeInstanceOf(KiloByteUnit::class);
});

it('can format number with unit', function () {
    expect(
        KiloByteUnit::make(10.00)->value()
    )->toEqual('10kB')
        ->and(
            KiloByteUnit::make(10.58)->value()
        )->toEqual('10.58kB')
        ->and(
            KiloByteUnit::make(10.50)->value()
        )->toEqual('10.5kB');
});

it('can retrieve unit alone', function () {
    expect(KiloByteUnit::unit())->toEqual('kB');
});
