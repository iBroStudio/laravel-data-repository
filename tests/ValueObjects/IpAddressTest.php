<?php

use IBroStudio\DataRepository\ValueObjects\IpAddress;
use Illuminate\Validation\ValidationException;

it('can instantiate', function () {
    expect(IpAddress::make(fake()->ipv4()))->toBeInstanceOf(IpAddress::class)
        ->and(IpAddress::make(fake()->ipv6()))->toBeInstanceOf(IpAddress::class);
});

it('throws error on validation', function () {
    IpAddress::make('116.112');
})->throws(ValidationException::class);

it('can give a well formated output', function () {
    $ipv4 = IpAddress::make(fake()->ipv4());
    $ipv6 = IpAddress::make(fake()->ipv6());

    expect($ipv4->value())->toEqual($ipv4)
        ->and($ipv6->value())->toEqual($ipv6);
});
