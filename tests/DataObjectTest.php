<?php

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\Models\Referable;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelExists;

it('can create DataObject', function () {
    $dataObject = DataObject::factory()->create();

    assertModelExists($dataObject);

    assertDatabaseHas(DataObject::class, [
        'referable_id' => $dataObject->referable_id,
        'referable_type' => $dataObject->referable_type,
        'class' => $dataObject->class,
        'values' => json_encode($dataObject->values),
    ]);
});

it('has a referable relation', function () {
    $referable = Referable::factory()->create();
    $dataObject = DataObject::factory()->referable($referable)->create();

    expect($dataObject->referable->is($referable))->toBeTrue();
});
