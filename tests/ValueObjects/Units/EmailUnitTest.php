<?php

use IBroStudio\DataRepository\ValueObjects\Units\EmailUnit;

it('can instantiate', function () {
    expect(EmailUnit::make(10))
        ->toBeInstanceOf(EmailUnit::class);
});

it('can format number with unit', function () {
    expect(
        EmailUnit::make(1)->value()
    )->toEqual('1 email')
        ->and(
            EmailUnit::make(10)->value()
        )->toEqual('10 emails');
});

it('can retrieve unit alone', function () {
    expect(EmailUnit::unit())
        ->toEqual('emails');
});
