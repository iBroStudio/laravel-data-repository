<?php

use IBroStudio\DataRepository\Tests\Support\Models\Referable;
use IBroStudio\DataRepository\ValueObjects\TimeDuration;
use IBroStudio\DataRepository\ValueObjects\Url;

it('can cast model property with value object', function () {
    $referable = Referable::factory()->create([
        'object_value_property' => 'https://ibro.studio',
    ]);

    expect($referable->object_value_property)
        ->toBeInstanceOf(Url::class);
});

it('can cast model property with TimeDuration value object', function () {
    $referable = Referable::factory()->create([
        'time_duration' => '12:05',
    ]);

    expect($referable->time_duration)
        ->toBeInstanceOf(TimeDuration::class);
});
