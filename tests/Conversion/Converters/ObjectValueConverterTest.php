<?php

use IBroStudio\DataRepository\Conversion\Converters\ObjectValueConverter;
use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ConvertiblesData;
use IBroStudio\DataRepository\ValueObjects;

it('can validate property class', function () {
    $converter = new ObjectValueConverter();
    $dataClass = new \ReflectionClass(ConvertiblesData::class);

    $valid_property = $dataClass->getProperty('text');
    $valid_reflection = new \ReflectionClass($valid_property->getType()->getName());

    expect($converter->validate($valid_reflection, $valid_property))->toBeTrue();

    $invalid_property = $dataClass->getProperty('simpleLaravelData');
    $invalid_reflection = new \ReflectionClass($invalid_property->getType()->getName());

    expect($converter->validate($invalid_reflection, $invalid_property))->toBeFalse();
});

it('can convert property', function (string $key, mixed $data, string $expectedClass) {
    $converter = new ObjectValueConverter();
    $dataClass = new \ReflectionClass(ConvertiblesData::class);
    $property = $dataClass->getProperty($key);
    $reflection = new \ReflectionClass($property->getType()->getName());

    expect($converter->convert($reflection, $property, $data))
        ->toBeInstanceOf($expectedClass);
})->with([
    ['text', fake()->text(), ValueObjects\Text::class],
    ['boolean', fake()->boolean(), ValueObjects\Boolean::class],
    ['number', fake()->numberBetween(), ValueObjects\Number::class],
    ['classString', DataObject::class, ValueObjects\ClassString::class],
    ['email', fake()->email(), ValueObjects\Email::class],
    ['encryptableText', fake()->word(), ValueObjects\EncryptableText::class],
    ['fullName', fake()->name(), ValueObjects\FullName::class],
    ['hashedPassword', fake()->password(), ValueObjects\HashedPassword::class],
    ['name', fake()->firstName(), ValueObjects\Name::class],
    ['phone', fake()->e164PhoneNumber(), ValueObjects\Phone::class],
    ['taxNumber', 'FR54879706885', ValueObjects\TaxNumber::class],
    ['timecode', fake()->time('H:i:s:v'), ValueObjects\Timecode::class],
    ['uri', fake()->url(), ValueObjects\Uri::class],
    ['url', fake()->url(), ValueObjects\Url::class],
    ['uuid', fake()->uuid(), ValueObjects\Uuid::class],
]);
