<?php

use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use Illuminate\Support\Facades\Crypt;

it('can instantiate', function () {
    $encryptableText = EncryptableText::make(fake()->word());

    expect($encryptableText)->toBeInstanceOf(EncryptableText::class);
});

it('can instantiate from encrypted string', function () {
    $encrypted = Crypt::encryptString(fake()->word());
    $encryptableText = EncryptableText::make($encrypted);

    expect($encryptableText)->toBeInstanceOf(EncryptableText::class);
});

it('validate encrypted value', function () {
    new EncryptableText(fake()->word());
})->throws(\InvalidArgumentException::class);

it('can decrypt', function () {
    $text = fake()->word();
    $encryptableText = EncryptableText::make($text);

    expect($encryptableText->decrypt())->toEqual($text);
});
