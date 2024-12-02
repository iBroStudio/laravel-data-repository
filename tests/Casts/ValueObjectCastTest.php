<?php

use IBroStudio\DataRepository\Tests\Support\Models\Referable;

it('can cast model property with value object', function () {
    $referable = Referable::factory()->create([
        'object_value_property' => 'https://ibro.studio',
    ]);

    dd($referable->object_value_property);
});
