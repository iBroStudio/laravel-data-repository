<?php

use IBroStudio\DataRepository\ValueObjects\FirstName;
use Illuminate\Support\Str;

it('can instantiate', function () {
    expect(FirstName::make(fake()->firstName))
        ->toBeInstanceOf(FirstName::class);
});

it('formats name', function () {
    $name = fake()->firstName;

    expect(
        FirstName::make($name)->value()
    )->toEqual(Str::ucfirst($name));
});

it('formats bad typed name', function () {
    expect(
        FirstName::make('yANN')->value()
    )->toEqual(Str::ucfirst('Yann'));
});
