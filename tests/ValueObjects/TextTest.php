<?php

use IBroStudio\DataRepository\ValueObjects\Text;
use Illuminate\Validation\ValidationException;

it('can instantiate Text object value', function () {
    expect(Text::from(fake()->word))
        ->toBeInstanceOf(Text::class);
});

it('can validate Text object value', function () {
    Text::from('');
})->throws(ValidationException::class);

it('can return null', function () {
    expect(Text::fromOrNull(''))
        ->toBeNull();
});

it('can return Text object value as array', function () {
    expect(
        Text::from('test')->toArray()
    )->toMatchArray([
        0 => 'test',
    ]);
});

it('can return Text object value as json', function () {
    expect(
        Text::from('test')->toJson()
    )->toBe('["test"]');
});
