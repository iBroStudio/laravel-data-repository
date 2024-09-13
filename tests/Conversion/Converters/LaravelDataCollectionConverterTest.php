<?php

use IBroStudio\DataRepository\Conversion\Converters\LaravelDataCollectionConverter;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ConvertiblesData;
use IBroStudio\DataRepository\Tests\Support\DataObjects\NestedData;
use IBroStudio\DataRepository\Tests\Support\DataObjects\OtherReferableData;
use IBroStudio\DataRepository\Tests\Support\DataObjects\WithEncryptableTextData;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

it('can validate property class', function () {
    $converter = new LaravelDataCollectionConverter;
    $dataClass = new \ReflectionClass(ConvertiblesData::class);

    $valid_property = $dataClass->getProperty('simpleCollection');
    $valid_reflection = new \ReflectionClass($valid_property->getType()->getName());

    expect($converter->validate($valid_reflection, $valid_property))->toBeTrue();

    $invalid_property = $dataClass->getProperty('simpleLaravelData');
    $invalid_reflection = new \ReflectionClass($invalid_property->getType()->getName());

    expect($converter->validate($invalid_reflection, $invalid_property))->toBeFalse();
});

it('can convert property', function () {
    $converter = new LaravelDataCollectionConverter;
    $dataClass = new \ReflectionClass(ConvertiblesData::class);
    $data = [
        'simpleCollection' => [
            ['name' => fake()->name()],
            ['name' => fake()->name()],
            ['name' => fake()->name()],
            ['name' => fake()->name()],
            ['name' => fake()->name()],
        ],
        'withValueObjectCollection' => [
            [
                'name' => fake()->name(),
                'secret' => fake()->password(),
            ],
            [
                'name' => fake()->name(),
                'secret' => fake()->password(),
            ],
            [
                'name' => fake()->name(),
                'secret' => fake()->password(),
            ],
        ],
        'nestedDataCollection' => [
            [
                'name' => fake()->name(),
                'encryptableTextData' => [
                    'name' => fake()->name(),
                    'secret' => fake()->password(),
                ],
            ],
            [
                'name' => fake()->name(),
                'encryptableTextData' => [
                    'name' => fake()->name(),
                    'secret' => fake()->password(),
                ],
            ],
            [
                'name' => fake()->name(),
                'encryptableTextData' => [
                    'name' => fake()->name(),
                    'secret' => fake()->password(),
                ],
            ],
        ],
    ];

    $simpleCollection = $dataClass->getProperty('simpleCollection');
    $simpleCollection_reflection = new \ReflectionClass($simpleCollection->getType()->getName());

    expect($converted = $converter->convert($simpleCollection_reflection, $simpleCollection, $data['simpleCollection']))
        ->toBeCollection()
        ->and($converted->first())->toBeInstanceOf(OtherReferableData::class);

    $withValueObjectCollection = $dataClass->getProperty('withValueObjectCollection');
    $withValueObjectCollection_reflection = new \ReflectionClass($withValueObjectCollection->getType()->getName());

    expect($converted = $converter->convert($withValueObjectCollection_reflection, $withValueObjectCollection, $data['withValueObjectCollection']))
        ->toBeCollection()
        ->and($converted->first())->toBeInstanceOf(WithEncryptableTextData::class)
        ->and($converted->first()->secret)->toBeInstanceOf(EncryptableText::class);

    $nestedDataCollection = $dataClass->getProperty('nestedDataCollection');
    $nestedDataCollection_reflection = new \ReflectionClass($nestedDataCollection->getType()->getName());

    expect($converted = $converter->convert($nestedDataCollection_reflection, $nestedDataCollection, $data['nestedDataCollection']))
        ->toBeCollection()
        ->and($converted->first())->toBeInstanceOf(NestedData::class)
        ->and($converted->first()->encryptableTextData)->toBeInstanceOf(WithEncryptableTextData::class)
        ->and($converted->first()->encryptableTextData->secret)->toBeInstanceOf(EncryptableText::class);
});
