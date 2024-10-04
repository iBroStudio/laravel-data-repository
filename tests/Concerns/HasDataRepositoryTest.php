<?php

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ReferableData;
use IBroStudio\DataRepository\Tests\Support\Models\Referable;
use IBroStudio\DataRepository\ValueObjects;
use MichaelRubel\ValueObjects\ValueObject;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('can save data object', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
        authentication: ValueObjects\Authentication\SshAuthentication::make(
            username: fake()->userName(),
            privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
            passphrase: ValueObjects\EncryptableText::make(fake()->password()),
        )
    );

    $referable->data_repository()->add($data);

    $dataFromRepository = $referable->data_repository(ReferableData::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values()->toArray())->toMatchArray($data->toArray());
});

it('can save simple value object', function (ValueObject $data) {
    $referable = Referable::factory()->create();
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository($data::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values()->toArray())->toMatchArray($data->toArray());
})->with([
    'text' => ValueObjects\Text::make(fake()->name()),
    'boolean' => ValueObjects\Boolean::make(fake()->boolean()),
    'number' => ValueObjects\Number::make(fake()->randomNumber()),
]);

it('can save complex value object', function ($data) {
    $referable = Referable::factory()->create();
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository($data::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values()->toArray())->toMatchArray($data->toArray());
})->with([
    'classString' => fn () => ValueObjects\ClassString::make(fake()->name()),
    'email' => fn () => ValueObjects\Email::make(fake()->email()),
    'fullName' => fn () => ValueObjects\FullName::make(fake()->name()),
    'name' => fn () => ValueObjects\Name::make(fake()->name()),
    'phone' => fn () => ValueObjects\Phone::make((string) fake()->randomNumber(9)),
    'taxNumber' => fn () => ValueObjects\TaxNumber::make(
        number: (string) fake()->randomNumber(9),
        prefix: 'FR'
    ),
    'url' => fn () => ValueObjects\Url::make(fake()->url()),
    'uuid' => fn () => ValueObjects\Uuid::make(fake()->uuid()),
    'encryptable' => fn () => ValueObjects\EncryptableText::make(fake()->password()),
    'basic-auth' => fn () => ValueObjects\Authentication\BasicAuthentication::make(
        username: fake()->userName(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
    ),
    'ssh-auth' => fn () => ValueObjects\Authentication\SshAuthentication::make(
        username: fake()->userName(),
        privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
        passphrase: ValueObjects\EncryptableText::make(fake()->password()),
    ),
    'authentication-with-basic' => fn () => ValueObjects\Authentication\BasicAuthentication::make(
        username: fake()->userName(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
    ),
    'authentication-with-ssh' => fn () => ValueObjects\Authentication\SshAuthentication::make(
        username: fake()->userName(),
        privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
        passphrase: ValueObjects\EncryptableText::make(fake()->password()),
    ),
]);

it('can save only one value per referable type without constraint', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
        authentication: ValueObjects\Authentication\SshAuthentication::make(
            username: fake()->userName(),
            privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
            passphrase: ValueObjects\EncryptableText::make(fake()->password()),
        )
    );
    $data2 = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
        authentication: ValueObjects\Authentication\SshAuthentication::make(
            username: fake()->userName(),
            privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
            passphrase: ValueObjects\EncryptableText::make(fake()->password()),
        )
    );
    $referable->data_repository()->add($data);
    $referable->data_repository()->add($data2);
    $dataFromRepository = $referable->data_repository(ReferableData::class);

    expect($dataFromRepository->count())->toBe(1)
        ->and($dataFromRepository->values()->name)->toBe($data2->name);
});

it('can load referable with data_repository', function () {
    $referable = Referable::find(
        Referable::factory()->create()->id
    );

    expect($referable->relationLoaded('data_repository'))->toBeTrue();
});

it('can query data with values constraints', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
        authentication: ValueObjects\Authentication\SshAuthentication::make(
            username: fake()->userName(),
            privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
            passphrase: ValueObjects\EncryptableText::make(fake()->password()),
        )
    );
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository(
        dataClass: ReferableData::class,
        valuesQuery: ['name' => $data->name]
    );

    expect($dataFromRepository->values()->toArray())->toMatchArray($data->toArray());
});

it('can save data with values constraints', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
        authentication: ValueObjects\Authentication\SshAuthentication::make(
            username: fake()->userName(),
            privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
            passphrase: ValueObjects\EncryptableText::make(fake()->password()),
        )
    );
    $data2 = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
        authentication: ValueObjects\Authentication\SshAuthentication::make(
            username: fake()->userName(),
            privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
            passphrase: ValueObjects\EncryptableText::make(fake()->password()),
        )
    );
    $referable->data_repository()->add($data);
    $referable->data_repository()->add(
        data: $data2,
        valuesAttributes: [
            'values->name' => $data2->name,
        ]
    );

    expect($referable->data_repository(ReferableData::class)->count())->toBe(2)
        ->and(
            $referable->data_repository(
                dataClass: ReferableData::class,
                valuesQuery: ['name' => $data->name]
            )
                ->values()
                ->toArray()
        )->toMatchArray($data->toArray())
        ->and(
            $referable->data_repository(
                dataClass: ReferableData::class,
                valuesQuery: ['name' => $data2->name]
            )
                ->values()
                ->toArray()
        )->toMatchArray($data2->toArray());
});

it('allows model to have dto attribute', function () {
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
        authentication: ValueObjects\Authentication\SshAuthentication::make(
            username: fake()->userName(),
            privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
            passphrase: ValueObjects\EncryptableText::make(fake()->password()),
        )
    );

    $referable = Referable::create([
        'dto_attribute' => $data,
    ]);

    $referable->save();

    expect($referable->dto_attribute->toArray())->toMatchArray($data->toArray());

    assertDatabaseHas(DataObject::class, [
        'referable_id' => $referable->id,
        'referable_type' => Referable::class,
        'class' => ReferableData::class,
        'values' => json_encode($data),
    ]);

    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
        authentication: ValueObjects\Authentication\SshAuthentication::make(
            username: fake()->userName(),
            privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
            passphrase: ValueObjects\EncryptableText::make(fake()->password()),
        )
    );
    $referable->dto_attribute = $data;

    $referable->save();

    expect($referable->dto_attribute->toArray())->toMatchArray($data->toArray());

    assertDatabaseHas(DataObject::class, [
        'referable_id' => $referable->id,
        'referable_type' => Referable::class,
        'class' => ReferableData::class,
        'values' => json_encode($data),
    ]);

    $referable = Referable::factory()->create();
    $data = ValueObjects\Email::make(fake()->email());

    $referable->dto_attribute = $data;

    $referable->save();

    expect($referable->dto_attribute->toArray())->toMatchArray($data->toArray());

    assertDatabaseHas(DataObject::class, [
        'referable_id' => $referable->id,
        'referable_type' => Referable::class,
        'class' => ValueObjects\Email::class,
        'values' => json_encode($data->toArray()),
    ]);

});

it('can delete dto attribute', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::make(fake()->password()),
        authentication: ValueObjects\Authentication\SshAuthentication::make(
            username: fake()->userName(),
            privateKey: ValueObjects\EncryptableText::make(fake()->macAddress()),
            passphrase: ValueObjects\EncryptableText::make(fake()->password()),
        )
    );
    $referable->dto_attribute = $data;

    $referable->save();

    $referable->delete();

    assertDatabaseMissing(DataObject::class, [
        'referable_id' => $referable->id,
        'referable_type' => Referable::class,
        'class' => ReferableData::class,
        'values' => json_encode($data),
    ]);
});
