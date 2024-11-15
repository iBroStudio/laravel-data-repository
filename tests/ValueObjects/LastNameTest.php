<?php

use IBroStudio\DataRepository\ValueObjects\LastName;
use Illuminate\Support\Str;

it('can instantiate', function () {
    expect(LastName::make(fake()->lastName))
        ->toBeInstanceOf(LastName::class);
});

it('formats name', function () {
    $name = fake()->lastName;

    expect(
        LastName::make($name)->value()
    )->toEqual(Str::upper($name));
});

