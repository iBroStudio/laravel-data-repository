<?php

use ByteUnits\Metric;
use IBroStudio\DataRepository\Enums\ByteUnitEnum;
use IBroStudio\DataRepository\ValueObjects\Units\Byte\ByteUnit;
use Illuminate\Validation\ValidationException;

it('can instantiate ByteUnit from string', function () {
    expect(
        ByteUnit::from('1.42MB')
    )->toBeInstanceOf(ByteUnit::class);
});

it('can instantiate ByteUnit from Metric', function () {
    expect(
        ByteUnit::from(Metric::gigabytes(12))
    )->toBeInstanceOf(ByteUnit::class);
});

it('can instantiate ByteUnit from number', function () {
    expect(
        ByteUnit::from(12.5)
    )->toBeInstanceOf(ByteUnit::class);
});

it('can validate ByteUnit', function () {
    ByteUnit::from('aaa');
})->throws(ValidationException::class);

it('can return ByteUnit value', function () {
    expect(
        ByteUnit::from('1.42MB')->value
    )->toEqual(1420000);
});

it('can return ByteUnit with unit', function () {
    expect(
        ByteUnit::from('1.42MB')->withUnit()
    )->toEqual('1.42MB');
});

it('can return ByteUnit unit', function () {
    expect(ByteUnit::unit())->toEqual('B');
});

it('can convert ByteUnit', function () {
    expect(
        ByteUnit::from('120MB')->convertIn(ByteUnitEnum::GB)
    )->toEqual('0.12GB');
});

it('can compare ByteUnit values', function () {
    $value = ByteUnit::from('1.42MB');
    $value2 = ByteUnit::from('2MB');
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
