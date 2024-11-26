<?php

use IBroStudio\DataRepository\Enums\Currencies;
use Illuminate\Support\Facades\Config;

it('can retrieve label', function () {
    expect(
        Currencies::EUR->getLabel()
    )->toBe('Euro');
});

it('can retrieve alpha code', function () {
    expect(
        Currencies::EUR->getAlphaCode()
    )->toBe('EUR');
});

it('can retrieve numeric code', function () {
    expect(
        Currencies::EUR->getNumericCode()
    )->toBe('978');
});

it('can filter enabled currencies', function () {
    Config::set('app.currencies', ['EUR', 'USD']);

    expect(Currencies::enabled())->toMatchArray([Currencies::EUR, Currencies::USD]);
});
