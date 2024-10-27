<?php

use IBroStudio\DataRepository\ValueObjects\Units\Byte\ExaByteUnit;

it('can instantiate', function () {
    expect(ExaByteUnit::make(10))
        ->toBeInstanceOf(ExaByteUnit::class);
});

it('can format number with unit', function () {
    expect(
        ExaByteUnit::make(10.00)->value()
    )->toEqual('10EB')
        ->and(
            ExaByteUnit::make(10.58)->value()
        )->toEqual('10.58EB')
        ->and(
            ExaByteUnit::make(10.50)->value()
        )->toEqual('10.5EB');
});

it('can retrieve unit alone', function () {
    expect(ExaByteUnit::unit())->toEqual('EB');
});
