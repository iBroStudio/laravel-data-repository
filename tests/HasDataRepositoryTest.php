<?php

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ReferableData;
use IBroStudio\DataRepository\Tests\Support\Models\Referable;
use MichaelRubel\ValueObjects\Collection\Complex\TaxNumber;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

it('can save data object', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(name: fake()->name());
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository(ReferableData::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values())->toEqual($data);
});

it('can save simple value object', function () {
    $referable = Referable::factory()->create();
    $data = Text::make(fake()->name());
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository(Text::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values())->toEqual($data);
});

it('can save complex value object', function () {
    $referable = Referable::factory()->create();
    $data = TaxNumber::make(number: (string) fake()->randomNumber(9), prefix: 'FR');
    $referable->data_repository()->add($data);
    $dataFromRepository = $referable->data_repository(TaxNumber::class);

    expect($dataFromRepository->first())->toBeInstanceOf(DataObject::class)
        ->and($dataFromRepository->values())->toEqual($data);
});

it('can save only one value per referable type', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(name: fake()->name());
    $data2 = new ReferableData(name: fake()->name());
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
