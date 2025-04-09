<?php

use IBroStudio\DataRepository\Conversion\Converters\EnumConverter;
use IBroStudio\DataRepository\Conversion\Converters\LaravelDataCollectionConverter;
use IBroStudio\DataRepository\Conversion\Converters\LaravelDataConverter;
use IBroStudio\DataRepository\Conversion\Converters\ObjectValueConverter;
use IBroStudio\DataRepository\Conversion\DataPropertiesConverter;
use IBroStudio\DataRepository\Conversion\DataPropertiesMapper;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ConvertiblesData;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

it('can instantiate class', function () {
    $instance = new DataPropertiesConverter(ConvertiblesData::class);

    expect($instance)->toBeInstanceOf(DataPropertiesConverter::class)
        ->and($instance->properties)->toBeCollection()
        ->and($instance->properties->first())->toBeInstanceOf(ReflectionProperty::class)
        ->and($instance->map)->toBeCollection()->toHaveCount(0)
        ->and(getProperty($instance, 'mapper'))->toBeInstanceOf(DataPropertiesMapper::class);
});

it('can convert data with a pipeline', function () {
    $converters = [];
    foreach (config('data-repository.properties_converters') as $converterClass) {
        $converter = Mockery::mock($converterClass);
        $converter->shouldReceive('handle')
            ->andReturnUsing(function ($data, $next) {
                return $next($data);
            });
        $converters[] = $converter;
    }

    $manager = (new DataPropertiesConverter(ConvertiblesData::class));
    $manager->data = new Collection;

    $convert = app(Pipeline::class)
        ->send($manager)
        ->through($converters)
        ->thenReturn()
        ->data;

    expect($convert)->toBeCollection();
});

it('can process through converter', function ($converterClass) {
    $mapper = Mockery::mock(DataPropertiesMapper::class)->makePartial();
    $mapper->shouldReceive('mapProperty')
        ->andReturn([
            'converter' => $converterClass,
            'object' => 'fake',
            'attribute' => [],
        ]);

    $manager = new DataPropertiesConverter(ConvertiblesData::class);
    $manager->data = collect([
        'text' => null,
        'boolean' => null,
        'number' => null,
        'classString', null,
        'email' => null,
        'encryptableText' => null,
        'fullName' => null,
        'hashedPassword' => null,
        'name' => null,
        'phone' => null,
        'taxNumber', null,
        'timecode' => null,
        'uri' => null,
        'url' => null,
        'uuid' => null,
        'simpleLaravelData' => null,
        'withValueObjectLaravelData' => null,
        'nestedData' => null,
        'simpleCollection' => [[null], [null], [null], [null], [null]],
        'withValueObjectCollection' => [[null], [null], [null]],
        'nestedDataCollection' => [[null], [null], [null]],
        'countryEnum' => null,
        'currencyEnum' => null,
        'timezoneEnum' => null,
    ]);

    $fixtures = [
        'ObjectValueConverter' => [
            'expected_properties_count' => $manager->properties->count() - 16,
            'properties' => ['text', 'boolean', 'integer', 'float', 'classString', 'email', 'encryptableText', 'fullName', 'hashedPassword', 'name', 'phone', 'vatNumber', 'timecode', 'url', 'uuid'],
        ],
        'LaravelDataConverter' => [
            'expected_properties_count' => $manager->properties->count() - 4,
            'properties' => ['simpleLaravelData', 'withValueObjectLaravelData', 'nestedData'],
        ],
        'LaravelDataCollectionConverter' => [
            'expected_properties_count' => $manager->properties->count() - 4,
            'properties' => ['simpleCollection', 'withValueObjectCollection', 'nestedDataCollection'],
        ],
        'EnumConverter' => [
            'expected_properties_count' => $manager->properties->count() - 4,
            'properties' => ['countryEnum', 'currencyEnum', 'timezoneEnum'],
        ],
    ];

    $converter = Mockery::mock($converterClass);
    $converter_key = Str::after($converter::class, 'IBroStudio_DataRepository_Conversion_Converters_');
    $converter->shouldReceive('validate')->andReturnUsing(function ($data, $property) use ($converter_key, $fixtures) {
        return in_array($property->getName(), $fixtures[$converter_key]['properties']);
    });
    $converter->shouldReceive('convert')->andReturn(fake()->word());

    $manager->processThroughConverter($converter);

    expect($manager->properties->count())->toBe($fixtures[$converter_key]['expected_properties_count']);

})->with([
    ObjectValueConverter::class,
    LaravelDataConverter::class,
    LaravelDataCollectionConverter::class,
    EnumConverter::class,
]);
