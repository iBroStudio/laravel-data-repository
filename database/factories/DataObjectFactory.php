<?php

namespace IBroStudio\DataRepository\Database\Factories;

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ReferableData;
use IBroStudio\DataRepository\Tests\Support\Models\Referable;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataObjectFactory extends Factory
{
    protected $model = DataObject::class;

    public function definition()
    {
        return [
            'referable_id' => Referable::factory(),
            'referable_type' => Referable::class,
            'class' => ReferableData::class,
            'values' => new ReferableData(name: fake()->name()),
        ];
    }

    public function referable(Referable $referable): static
    {
        return $this->state(fn (array $attributes) => [
            'referable_id' => $referable->id,
        ]);
    }
}
