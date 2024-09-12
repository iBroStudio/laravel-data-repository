<?php

use IBroStudio\DataRepository\Conversion\Converters\LaravelDataConverter;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ConvertiblesData;
use IBroStudio\DataRepository\Tests\Support\DataObjects\NestedData;
use IBroStudio\DataRepository\Tests\Support\DataObjects\OtherReferableData;
use IBroStudio\DataRepository\Tests\Support\DataObjects\WithEncryptableTextData;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

it('can validate property', function () {
    $converter = new LaravelDataConverter();
    $dataClass = new \ReflectionClass(ConvertiblesData::class);

    $valid_property = $dataClass->getProperty('simpleLaravelData');
    $valid_reflection = new \ReflectionClass($valid_property->getType()->getName());

    expect($converter->validate($valid_reflection, $valid_property))->toBeTrue();

    $invalid_property = $dataClass->getProperty('text');
    $invalid_reflection = new \ReflectionClass($invalid_property->getType()->getName());

    expect($converter->validate($invalid_reflection, $invalid_property))->toBeFalse();
});

it('can convert property', function () {
    $converter = new LaravelDataConverter();
    $dataClass = new \ReflectionClass(ConvertiblesData::class);
    $data = [
        'simpleLaravelData' => [
            'name' => fake()->name(),
        ],
        'withValueObjectLaravelData' => [
            'name' => fake()->name(),
            'secret' => fake()->password(),
        ],
        'nestedData' => [
            'name' => fake()->name(),
            'encryptableTextData' => [
                'name' => fake()->name(),
                'secret' => fake()->password(),
            ],
        ],
    ];

    $simpleLaravelData = $dataClass->getProperty('simpleLaravelData');
    $simpleLaravelData_reflection = new \ReflectionClass($simpleLaravelData->getType()->getName());

    expect($converter->convert($simpleLaravelData_reflection, $simpleLaravelData, $data['simpleLaravelData']))
        ->toBeInstanceOf(OtherReferableData::class);

    $withValueObjectLaravelData = $dataClass->getProperty('withValueObjectLaravelData');
    $withValueObjectLaravelData_reflection = new \ReflectionClass($withValueObjectLaravelData->getType()->getName());

    expect($converted = $converter->convert($withValueObjectLaravelData_reflection, $withValueObjectLaravelData, $data['withValueObjectLaravelData']))
        ->toBeInstanceOf(WithEncryptableTextData::class)
        ->and($converted->secret)->toBeInstanceOf(EncryptableText::class);

    $nestedData = $dataClass->getProperty('nestedData');
    $nestedData_reflection = new \ReflectionClass($nestedData->getType()->getName());

    expect($converted = $converter->convert($nestedData_reflection, $nestedData, $data['nestedData']))
        ->toBeInstanceOf(NestedData::class)
        ->and($converted->encryptableTextData)->toBeInstanceOf(WithEncryptableTextData::class)
        ->and($converted->encryptableTextData->secret)->toBeInstanceOf(EncryptableText::class);
});
