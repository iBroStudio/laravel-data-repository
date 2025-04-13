<?php

use IBroStudio\DataRepository\Exceptions\DataObjectCastException;
use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\DataObjects\OtherReferableData;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ReferableData;
use IBroStudio\DataRepository\Tests\Support\Models\Referable;
use IBroStudio\DataRepository\Tests\Support\Models\ReferableWithConstrainedCast;
use IBroStudio\DataRepository\ValueObjects;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('can save data object', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
        )
    );

    $referable->data_repository()->add($data);

    $dataFromRepository = $referable->data_repository(ReferableData::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values()->toArray())->toMatchArray($data->toArray());
});

it('cascade delete data object', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
        )
    );

    $referable->data_repository()->add($data);

    $referable->delete();

    assertDatabaseMissing(DataObject::class, [
        'referable_id' => $referable->id,
        'referable_type' => Referable::class,
        'class' => ReferableData::class,
        'values' => json_encode($data),
    ]);
});

it('can save simple value object', function (ValueObjects\ValueObject $data) {
    $referable = Referable::factory()->create();
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository($data::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values()->toArray())->toMatchArray($data->toArray());
})->with([
    'text' => ValueObjects\Text::from(fake()->name()),
    'boolean' => ValueObjects\Boolean::from(fake()->boolean()),
    'number' => ValueObjects\IntegerValueObject::from(fake()->randomNumber()),
]);

it('can save complex value object', function ($data) {
    $referable = Referable::factory()->create();
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository($data::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values()->toArray())->toMatchArray($data->toArray());
})->with([
    'classString' => fn () => ValueObjects\ClassString::from(fake()->name()),
    'email' => fn () => ValueObjects\Email::from(fake()->email()),
    'fullName' => fn () => ValueObjects\FullName::from(fake()->name()),
    'name' => fn () => ValueObjects\Name::from(fake()->name()),
    'phone' => fn () => ValueObjects\Phone::from('+33102030405'),
    'taxNumber' => fn () => ValueObjects\VatNumber::from('FR54879706885'),
    'url' => fn () => ValueObjects\Url::from(fake()->url()),
    'uuid' => fn () => ValueObjects\Uuid::from(fake()->uuid()),
    'encryptable' => fn () => ValueObjects\EncryptableText::from(fake()->password()),
    'basic-auth' => fn () => ValueObjects\Authentication\BasicAuthentication::from(
        username: fake()->userName(),
        password: ValueObjects\EncryptableText::from(fake()->password()),
    ),
    'ssh-key' => fn () => ValueObjects\Authentication\SshKey::from(
        user: fake()->userName(),
        key: ValueObjects\EncryptableText::from(fake()->sshKey()),
        passphrase: ValueObjects\EncryptableText::from(fake()->password()),
    ),
]);

it('can save only one value per referable type without constraint', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
        )
    );
    $data2 = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
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
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
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
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
        )
    );
    $data2 = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
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
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
        )
    );
    $referable = Referable::create(['dto_attribute' => $data]);

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
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
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
    $data = ValueObjects\Email::from(fake()->email());

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

it('throws exception with constrained dto attribute', function () {
    ReferableWithConstrainedCast::create([
        'dto_attribute' => new ReferableData(
            name: fake()->name(),
            password: ValueObjects\EncryptableText::from(fake()->password()),
            authentication: ValueObjects\Authentication\SshKey::from(
                user: fake()->userName(),
                key: ValueObjects\EncryptableText::from(fake()->sshKey()),
                passphrase: ValueObjects\EncryptableText::from(fake()->password()),
            )
        ),
    ]);
})->throws(DataObjectCastException::class, 'dto_attribute is not a IBroStudio\DataRepository\Tests\Support\DataObjects\OtherReferableData');

it('allows model to have constrained dto attribute', function () {
    $data = OtherReferableData::from(['name' => fake()->name]);
    $referable = Referable::create(['dto_attribute' => $data]);

    expect($referable->dto_attribute->toArray())->toMatchArray($data->toArray());
});

it('can delete dto attribute', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: ValueObjects\EncryptableText::from(fake()->password()),
        authentication: ValueObjects\Authentication\SshKey::from(
            user: fake()->userName(),
            key: ValueObjects\EncryptableText::from(fake()->sshKey()),
            passphrase: ValueObjects\EncryptableText::from(fake()->password()),
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
