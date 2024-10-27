<?php

use IBroStudio\DataRepository\ValueObjects\Units\Byte\GigaByteUnit;

it('can instantiate', function () {
    expect(GigaByteUnit::make(10))
        ->toBeInstanceOf(GigaByteUnit::class);
});

it('can format number with unit', function () {
    expect(
        GigaByteUnit::make(10.00)->value()
    )->toEqual('10GB')
        ->and(
            GigaByteUnit::make(10.58)->value()
        )->toEqual('10.58GB')
        ->and(
            GigaByteUnit::make(10.50)->value()
        )->toEqual('10.5GB');
});

it('can retrieve unit alone', function () {
    expect(GigaByteUnit::unit())->toEqual('GB');
});
