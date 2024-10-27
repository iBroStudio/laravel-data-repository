<?php

use IBroStudio\DataRepository\ValueObjects\Units\IntegerUnit;

it('can instantiate', function () {
    expect(IntegerUnit::make(10))
        ->toBeInstanceOf(IntegerUnit::class);
});

it('can format number with unit', function () {
    expect(IntegerUnit::make(1)->value())
        ->toEqual('1');
});

it('can retrieve unit alone', function () {
    expect(IntegerUnit::unit())
        ->toBeNull();
});
