<?php

use IBroStudio\DataRepository\Enums\TimeUnitEnum;
use IBroStudio\DataRepository\ValueObjects\TimeDuration;

it('can instantiate from string', function () {
    expect(
        TimeDuration::make(fake()->time('H:i:s'))
    )->toBeInstanceOf(TimeDuration::class)
        ->and(
            TimeDuration::make(fake()->time('i:s'))
        )->toBeInstanceOf(TimeDuration::class);

});

it('can instantiate from float', function () {
    $duration = TimeDuration::make(3.5, unit: TimeUnitEnum::MINUTES);

    expect($duration)->toBeInstanceOf(TimeDuration::class)
        ->and($duration->value())->toBe('3.5');
});

it('can instantiate from float as string', function () {
    $duration = TimeDuration::make('3.5', unit: TimeUnitEnum::MINUTES);

    expect($duration)->toBeInstanceOf(TimeDuration::class);
});

it('can format', function () {
    $duration = TimeDuration::make(3.5, unit: TimeUnitEnum::MINUTES);

    expect($duration->format())->toBe('3 minutes 30 seconds')
        ->and($duration->format(short: true))->toBe('3m 30s');
});
