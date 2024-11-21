<?php

use IBroStudio\DataRepository\ValueObjects\CompanyName;

it('can instantiate', function () {
    expect(CompanyName::make('iBroStudio'))
        ->toBeInstanceOf(CompanyName::class);
});

it('formats name', function () {
    expect(
        CompanyName::make('iBroStudio')->value()
    )->toEqual('IBROSTUDIO');
});
