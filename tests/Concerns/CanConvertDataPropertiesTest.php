<?php

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ConvertiblesData;

it('can convert data properties', function () {
    $data = ConvertiblesData::fromConverters([
        'string' => fake()->text(),
        'text' => fake()->text(),
        'boolean' => fake()->boolean(),
        'integer' => fake()->numberBetween(),
        'float' => fake()->randomFloat(),
        'classString' => DataObject::class,
        'email' => fake()->email(),
        'encryptableText' => fake()->word(),
        'fullName' => fake()->name(),
        'hashedPassword' => fake()->password(8),
        'name' => fake()->firstName(),
        'phone' => '+33102030405',
        'vatNumber' => 'FR54879706885',
        'timecode' => fake()->time('H:i:s:v'),
        'url' => fake()->url(),
        'uuid' => fake()->uuid(),
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
        'countryEnum' => 'FR',
        'currencyEnum' => 'EUR',
        'timezoneEnum' => 'Europe/Paris',
    ]);

    expect($data)->toBeInstanceOf(ConvertiblesData::class);
});
