<?php

namespace IBroStudio\DataRepository\Tests\Support\Database\Factories;

use IBroStudio\DataRepository\Tests\Support\Models\FakeModelWithCustomClassProperty;
use Illuminate\Database\Eloquent\Factories\Factory;

class FakeModelWithCustomClassPropertyFactory extends Factory
{
    protected $model = FakeModelWithCustomClassProperty::class;

    public function definition(): array
    {
        return [];
    }
}
