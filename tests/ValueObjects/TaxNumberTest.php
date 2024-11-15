<?php

use IBroStudio\DataRepository\ValueObjects\TaxNumber;

it('can instantiate', function () {
    expect(TaxNumber::make('FR54879706885'))
        ->toBeInstanceOf(TaxNumber::class);
});

it('can give full tax number name', function () {
    expect(
        TaxNumber::make('FR54879706885')->value()
    )->toEqual('FR54879706885');
});

it('can give tax number name without prefix', function () {
    expect(
        TaxNumber::make('FR54879706885')->taxNumber()
    )->toEqual('54879706885');
});

