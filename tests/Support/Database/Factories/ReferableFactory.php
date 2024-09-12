<?php

namespace IBroStudio\DataRepository\Tests\Support\Database\Factories;

use IBroStudio\DataRepository\Tests\Support\Models\Referable;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferableFactory extends Factory
{
    protected $model = Referable::class;

    public function definition(): array
    {
        return [];
    }
}
