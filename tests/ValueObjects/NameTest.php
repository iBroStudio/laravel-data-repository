<?php

use IBroStudio\DataRepository\ValueObjects\Name;

it('can instantiate', function () {
    expect(Name::make('yann'))
        ->toBeInstanceOf(Name::class);
});

it('formats name', function () {
    expect(
        Name::make('yanN')->value()
    )->toEqual('Yann');
});

