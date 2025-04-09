<?php

use IBroStudio\DataRepository\ValueObjects\Units\IntegerUnit;

it('can instantiate IntegerUnit', function () {
    expect(IntegerUnit::from(10))
        ->toBeInstanceOf(IntegerUnit::class);
});

it('can return IntegerUnit with unit', function () {
    expect(
        IntegerUnit::from(10)->withUnit()
    )->toEqual('10');
});

it('can return IntegerUnit unit', function () {
    expect(IntegerUnit::unit())
        ->toBeNull();
});
