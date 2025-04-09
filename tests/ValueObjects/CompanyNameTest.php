<?php

use IBroStudio\DataRepository\ValueObjects\CompanyName;

it('can instantiate CompanyName object value', function () {
    expect(CompanyName::from('iBroStudio'))
        ->toBeInstanceOf(CompanyName::class);
});

it('formats name CompanyName object value', function () {
    expect(
        CompanyName::from('iBroStudio')->value
    )->toEqual('Ibrostudio');
});
