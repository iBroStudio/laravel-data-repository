<?php

use IBroStudio\DataRepository\ValueObjects\Authentication\S3Authentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

it('can instantiate', function (string $key, EncryptableText|string $secret) {
    $s3Authentication = S3Authentication::make(
        key: $key,
        secret: $secret,
    );

    expect($s3Authentication)->toBeInstanceOf(S3Authentication::class);
})->with([
    'encrypted' => fn () => [
        fake()->uuid(),
        EncryptableText::make(fake()->password()),
    ],
    'strings' => fn () => [
        fake()->uuid(),
        EncryptableText::make(fake()->password())->value(),
    ],
]);

it('can provide properties', function () {
    $key = fake()->uuid();
    $secret = fake()->password();
    $s3Authentication = S3Authentication::make(
        key: $key,
        secret: EncryptableText::make($secret),
    );

    expect($s3Authentication->key())->toBe($key);
    expect($s3Authentication->secret())->toBe($secret);
});
