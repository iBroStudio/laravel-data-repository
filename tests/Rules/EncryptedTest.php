<?php

use IBroStudio\DataRepository\Rules\Encrypted;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

it('can validate encrypted value', function () {
    $value = fake()->word();
    $encrypted = Crypt::encryptString($value);
    $validator = Validator::make(['value' => $encrypted], [
        'value' => new Encrypted,
    ]);

    expect($validator->fails())->toBeFalse();
});

it('fails validating uncrypted value', function () {
    $value = fake()->word();
    $validator = Validator::make(['value' => $value], [
        'value' => new Encrypted,
    ]);

    expect($validator->fails())->toBeTrue();
});
