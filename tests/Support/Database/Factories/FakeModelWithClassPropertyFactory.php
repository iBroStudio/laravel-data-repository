<?php

namespace IBroStudio\DataRepository\Tests\Support\Database\Factories;

use IBroStudio\DataRepository\Tests\Support\Models\FakeModelWithClassProperty;
use Illuminate\Database\Eloquent\Factories\Factory;

class FakeModelWithClassPropertyFactory extends Factory
{
    protected $model = FakeModelWithClassProperty::class;

    public function definition(): array
    {
        return [];
    }
}
