<?php

namespace IBroStudio\DataObjectsRepository\Tests\Support\Database\Factories;

use IBroStudio\DataObjectsRepository\Tests\Support\Models\Referable;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferableFactory extends Factory
{
    protected $model = Referable::class;

    public function definition()
    {
        return [];
    }
}
