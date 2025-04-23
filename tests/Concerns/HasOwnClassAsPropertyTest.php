<?php

use IBroStudio\DataRepository\Tests\Support\Models\FakeModelWithClassProperty;
use IBroStudio\DataRepository\Tests\Support\Models\FakeModelWithCustomClassProperty;
use IBroStudio\DataRepository\Tests\Support\Models\Referable;

it('can save own class as property', function () {
    $model = FakeModelWithClassProperty::factory()->create();

    expect($model->class)->toBe(FakeModelWithClassProperty::class);
});

it('can save own class with custom property name', function () {
    $model = FakeModelWithCustomClassProperty::factory()->create();

    expect($model->type)->toBe(FakeModelWithCustomClassProperty::class);
});

it('can scope queries to class property', function () {
    Referable::factory()->create();
    FakeModelWithClassProperty::factory()->create();

    expect(Referable::all()->count())->toBe(1)
        ->and(Referable::withoutGlobalScope('class')->count())->toBe(2);
});
