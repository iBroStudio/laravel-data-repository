<?php

use IBroStudio\DataObjectsRepository\Models\DataObject;
use IBroStudio\DataObjectsRepository\Tests\Support\DataObjects\ReferableData;
use IBroStudio\DataObjectsRepository\Tests\Support\Models\Referable;

it('can add a data_object to a referable', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(name: fake()->name());

    $referable->data_object()->add($data);

    expect($referable->data_object)->toBeInstanceOf(DataObject::class);
});

it('can give access to the dto instance thru the attribute', function () {
    $referable = Referable::factory()->create();
    $data = new ReferableData(name: fake()->name());

    $referable->data_object()->add($data);

    expect($referable->data_object->values)->toEqual($data);
});
