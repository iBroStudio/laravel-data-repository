<?php

use IBroStudio\DataRepository\Conversion\Converters\EnumConverter;
use IBroStudio\DataRepository\Enums\Countries;
use IBroStudio\DataRepository\Enums\Currencies;
use IBroStudio\DataRepository\Enums\Timezones;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ConvertiblesData;

it('can validate property', function () {
    $converter = new EnumConverter();
    $dataClass = new \ReflectionClass(ConvertiblesData::class);

    $valid_property = $dataClass->getProperty('countryEnum');
    $valid_reflection = new \ReflectionClass($valid_property->getType()->getName());

    expect($converter->validate($valid_reflection, $valid_property))->toBeTrue();

    $invalid_property = $dataClass->getProperty('text');
    $invalid_reflection = new \ReflectionClass($invalid_property->getType()->getName());

    expect($converter->validate($invalid_reflection, $invalid_property))->toBeFalse();
});

it('can convert property', function () {
    $converter = new EnumConverter();
    $dataClass = new \ReflectionClass(ConvertiblesData::class);
    $data = [
        'countryEnum' => 'FR',
        'currencyEnum' => 'EUR',
        'timezoneEnum' => 'Europe/Paris',
    ];

    $country = $dataClass->getProperty('countryEnum');
    $country_reflection = new \ReflectionClass($country->getType()->getName());

    expect($converter->convert($country_reflection, $country, $data['countryEnum']))
        ->toBeInstanceOf(Countries::class);

    $currency = $dataClass->getProperty('currencyEnum');
    $currency_reflection = new \ReflectionClass($currency->getType()->getName());

    expect($converter->convert($currency_reflection, $currency, $data['currencyEnum']))
        ->toBeInstanceOf(Currencies::class);

    $timezone = $dataClass->getProperty('timezoneEnum');
    $timezone_reflection = new \ReflectionClass($timezone->getType()->getName());

    expect($converter->convert($timezone_reflection, $timezone, $data['timezoneEnum']))
        ->toBeInstanceOf(Timezones::class);
});
