<?php

use IBroStudio\DataRepository\ValueObjects\Units\Byte\PetaByteUnit;

it('can instantiate', function () {
    expect(PetaByteUnit::make(10))
        ->toBeInstanceOf(PetaByteUnit::class);
});

it('can format number with unit', function () {
    expect(
        PetaByteUnit::make(10.00)->value()
    )->toEqual('10PB')
        ->and(
            PetaByteUnit::make(10.58)->value()
        )->toEqual('10.58PB')
        ->and(
            PetaByteUnit::make(10.50)->value()
        )->toEqual('10.5PB');
});

it('can retrieve unit alone', function () {
    expect(PetaByteUnit::unit())->toEqual('PB');
});
