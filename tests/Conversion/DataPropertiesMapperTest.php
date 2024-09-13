<?php

use IBroStudio\DataRepository\Contracts\Converter;
use IBroStudio\DataRepository\Conversion\DataPropertiesMapper;
use IBroStudio\DataRepository\Enums\Countries;
use IBroStudio\DataRepository\Exceptions\MissingConverterException;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ConvertiblesData;
use IBroStudio\DataRepository\Tests\Support\DataObjects\OtherReferableData;
use IBroStudio\DataRepository\ValueObjects;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

function getInstances(string $key): array
{
    $converter = Mockery::mock(Converter::class);
    $converter->shouldReceive('validate')->andReturn(true);
    $dataClass = new \ReflectionClass(ConvertiblesData::class);
    $property = $dataClass->getProperty($key);

    return [
        new DataPropertiesMapper,
        $converter,
        $property,
        // @phpstan-ignore-next-line
        new \ReflectionClass($property->getType()->getName()),
    ];
}

it('can map ValueObjects/Text property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('text');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Text::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/Boolean property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('boolean');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Boolean::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/Number property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('number');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Number::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/ClassString property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('classString');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\ClassString::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/Email property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('email');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Email::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/EncryptableText property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('encryptableText');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\EncryptableText::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/FullName property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('fullName');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\FullName::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/HashedPassword property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('hashedPassword');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\HashedPassword::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/Name property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('name');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Name::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/Phone property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('phone');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Phone::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/TaxNumber property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('taxNumber');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\TaxNumber::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/Timecode property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('timecode');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Timecode::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/Uri property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('uri');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Uri::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/Url property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('url');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Url::class,
            'attribute' => [],
        ]);
});

it('can map ValueObjects/Uuid property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('uuid');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => ValueObjects\Uuid::class,
            'attribute' => [],
        ]);
});

it('can map LaravelData property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('simpleLaravelData');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => OtherReferableData::class,
            'attribute' => [],
        ]);
});

it('can map LaravelData Collection property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('simpleCollection');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => Collection::class,
            'attribute' => [
                'name' => 'Spatie\LaravelData\Attributes\DataCollectionOf',
                'arguments' => [
                    'IBroStudio\DataRepository\Tests\Support\DataObjects\OtherReferableData',
                ],
            ],
        ]);
});

it('can map Enum property', function () {
    [$mapper, $converter, $property, $reflection] = getInstances('countryEnum');
    $map = $mapper->trough($converter)->mapProperty($property, $reflection);
    $map['converter'] = Str::after($map['converter'], 'IBroStudio_DataRepository_Contracts_');

    expect($map)
        ->toBeArray()
        ->toMatchArray([
            'converter' => 'Converter',
            'object' => Countries::class,
            'attribute' => [],
        ]);
});

it('throws exception if converter is not defined', function () {
    $mapper = new DataPropertiesMapper;
    $dataClass = new \ReflectionClass(ConvertiblesData::class);
    $property = $dataClass->getProperty('simpleLaravelData');
    // @phpstan-ignore-next-line
    $reflection = new \ReflectionClass($property->getType()->getName());
    $mapper->mapProperty($property, $reflection);
})->throws(MissingConverterException::class);
