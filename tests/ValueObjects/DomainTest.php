<?php

use IBroStudio\DataRepository\ValueObjects\Domain;
use Illuminate\Validation\ValidationException;

it('can instantiate', function () {
    expect(Domain::make('www.ibro.studio'))
        ->toBeInstanceOf(Domain::class);
});

it('can get domain', function () {
    expect(
        Domain::make('www.ibro.studio')
            ->value()
    )
        ->toBe('www.ibro.studio');
});

it('can get subdomain', function () {
    expect(
        Domain::make('www.ibro.studio')
            ->subdomain()
    )
        ->toBe('www');
});

it('can get domain name', function () {
    expect(
        Domain::make('www.ibro.studio')
            ->name()
    )
        ->toBe('ibro');
});

it('can get domain tld', function () {
    expect(
        Domain::make('www.ibro.studio')
            ->tld()
    )
        ->toBe('studio');
});

it('can get registrable domain', function () {
    expect(
        Domain::make('www.ibro.studio')
            ->registrable()
    )
        ->toBe('ibro.studio');
});

it('can not instantiate with non domain', function () {
    Domain::make('123');
})->throws(ValidationException::class);

it('can not instantiate when domain is in url', function () {
    Domain::make('https://www.ibro.studio');
})->throws(ValidationException::class);
