<?php

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ReferableData;
use IBroStudio\DataRepository\Tests\Support\Models\Referable;
use IBroStudio\DataRepository\ValueObjects\Authentication;
use IBroStudio\DataRepository\ValueObjects\BasicAuthentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\DataRepository\ValueObjects\SshAuthentication;
use MichaelRubel\ValueObjects\Collection\Complex\ClassString;
use MichaelRubel\ValueObjects\Collection\Complex\Email;
use MichaelRubel\ValueObjects\Collection\Complex\FullName;
use MichaelRubel\ValueObjects\Collection\Complex\Name;
use MichaelRubel\ValueObjects\Collection\Complex\Phone;
use MichaelRubel\ValueObjects\Collection\Complex\TaxNumber;
use MichaelRubel\ValueObjects\Collection\Complex\Url;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use MichaelRubel\ValueObjects\Collection\Primitive\Boolean;
use MichaelRubel\ValueObjects\Collection\Primitive\Number;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;
use MichaelRubel\ValueObjects\ValueObject;

it('can save data object', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: EncryptableText::make(fake()->password()),
        authentication: Authentication::make(
            SshAuthentication::make(
                privateKey: EncryptableText::make(fake()->macAddress()),
                passphrase: EncryptableText::make(fake()->password()),
            )
        )
    );
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository(ReferableData::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values())->toEqual($data);
});

it('can save simple value object', function (ValueObject $data) {
    $referable = Referable::factory()->create();
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository($data::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values())->toEqual($data);
})->with([
    'text' => Text::make(fake()->name()),
    'boolean' => Boolean::make(fake()->boolean()),
    'number' => Number::make(fake()->randomNumber()),
]);

it('can save complex value object', function ($data) {
    $referable = Referable::factory()->create();
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository($data::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values())->toEqual($data);
})->with([
    'classString' => fn () => ClassString::make(fake()->name()),
    'email' => fn () => Email::make(fake()->email()),
    'fullName' => fn () => FullName::make(fake()->name()),
    'name' => fn () => Name::make(fake()->name()),
    'phone' => fn () => Phone::make((string) fake()->randomNumber(9)),
    'taxNumber' => fn () => TaxNumber::make(
        number: (string) fake()->randomNumber(9),
        prefix: 'FR'
    ),
    'url' => fn () => Url::make(fake()->url()),
    'uuid' => fn () => Uuid::make(fake()->uuid()),
    'encryptable' => fn () => EncryptableText::make(fake()->password()),
    'basic-auth' => fn () => BasicAuthentication::make(
        username: fake()->userName(),
        password: EncryptableText::make(fake()->password()),
    ),
    'ssh-auth' => fn () => SshAuthentication::make(
        privateKey: EncryptableText::make(fake()->macAddress()),
        passphrase: EncryptableText::make(fake()->password()),
    ),
    'authentication-with-basic' => fn () => Authentication::make(
        BasicAuthentication::make(
            username: fake()->userName(),
            password: EncryptableText::make(fake()->password()),
        )
    ),
    'authentication-with-ssh' => fn () => Authentication::make(
        SshAuthentication::make(
            privateKey: EncryptableText::make(fake()->macAddress()),
            passphrase: EncryptableText::make(fake()->password()),
        )
    ),
]);

it('can save only one value per referable type', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: EncryptableText::make(fake()->password()),
        authentication: Authentication::make(
            SshAuthentication::make(
                privateKey: EncryptableText::make(fake()->macAddress()),
                passphrase: EncryptableText::make(fake()->password()),
            )
        )
    );
    $data2 = new ReferableData(
        name: fake()->name(),
        password: EncryptableText::make(fake()->password()),
        authentication: Authentication::make(
            SshAuthentication::make(
                privateKey: EncryptableText::make(fake()->macAddress()),
                passphrase: EncryptableText::make(fake()->password()),
            )
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
        password: EncryptableText::make(fake()->password()),
        authentication: Authentication::make(
            SshAuthentication::make(
                privateKey: EncryptableText::make(fake()->macAddress()),
                passphrase: EncryptableText::make(fake()->password()),
            )
        )
    );
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository(
        dataClass: ReferableData::class,
        valuesQuery: ['name' => $data->name]
    );

    expect($dataFromRepository->values())->toEqual($data);
});

it('can save data with values constraints', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(
        name: fake()->name(),
        password: EncryptableText::make(fake()->password()),
        authentication: Authentication::make(
            SshAuthentication::make(
                privateKey: EncryptableText::make(fake()->macAddress()),
                passphrase: EncryptableText::make(fake()->password()),
            )
        )
    );
    $data2 = new ReferableData(
        name: fake()->name(),
        password: EncryptableText::make(fake()->password()),
        authentication: Authentication::make(
            SshAuthentication::make(
                privateKey: EncryptableText::make(fake()->macAddress()),
                passphrase: EncryptableText::make(fake()->password()),
            )
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
        )->toEqual($data)
        ->and(
            $referable->data_repository(
                dataClass: ReferableData::class,
                valuesQuery: ['name' => $data2->name]
            )
                ->values()
        )->toEqual($data2);
});
