<?php

use IBroStudio\DataRepository\Enums\ByteUnitEnum;
use IBroStudio\DataRepository\ValueObjects\ByteUnit;
use Illuminate\Validation\ValidationException;

it('can instantiate', function () {
    expect(
        ByteUnit::make('1.42MB')
    )->toBeInstanceOf(ByteUnit::class);
});

it('throws error on validation', function () {
    ByteUnit::make('aaa');
})->throws(ValidationException::class);

it('throws error if unit is missing', function () {
    ByteUnit::make(120);
})->throws(TypeError::class);

it('can give a well formated output', function () {
    expect(
        ByteUnit::make('1.42MB')
    )->toEqual('1.42MB');
});

it('can convert unit', function () {
    expect(
        ByteUnit::make('120MB')->value(unit: ByteUnitEnum::GB)
    )->toEqual('0.12GB');
});

it('can compare values', function () {
    $value = ByteUnit::make('1.42MB');
    $value2 = ByteUnit::make('2MB');
    expect($value->isEqualTo('2GB'))->toBeFalse()
        ->and($value->isLessThanOrEqualTo('2GB'))->toBeTrue()
        ->and($value->isLessThan('2GB'))->toBeTrue()
        ->and($value->isGreaterThanOrEqualTo('2GB'))->toBeFalse()
        ->and($value->isGreaterThan('2GB'))->toBeFalse()
        ->and($value->isEqualTo('1.42MB'))->toBeTrue()
        ->and($value->isLessThanOrEqualTo('1.42MB'))->toBeTrue()
        ->and($value->isLessThan('1.42MB'))->toBeFalse()
        ->and($value->isGreaterThanOrEqualTo('1.42MB'))->toBeTrue()
        ->and($value->isGreaterThan('1.42MB'))->toBeFalse()
        ->and($value->isEqualTo('100B'))->toBeFalse()
        ->and($value->isLessThanOrEqualTo('100B'))->toBeFalse()
        ->and($value->isLessThan('100B'))->toBeFalse()
        ->and($value->isGreaterThanOrEqualTo('100B'))->toBeTrue()
        ->and($value->isGreaterThan('100B'))->toBeTrue()
        ->and($value->isEqualTo($value2))->toBeFalse()
        ->and($value->isLessThanOrEqualTo($value2))->toBeTrue()
        ->and($value->isLessThan($value2))->toBeTrue()
        ->and($value->isGreaterThanOrEqualTo($value2))->toBeFalse()
        ->and($value->isGreaterThan($value2))->toBeFalse();
});

it('can give the number of bytes', function () {
    expect(
        ByteUnit::make('1.42MB')
            ->bytes()
    )->toEqual(1420000);
});
