<?php

use IBroStudio\DataRepository\ValueObjects\BasicAuthentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

it('can instantiate', function (string $username, EncryptableText|string $password) {
    $basicAuthentication = BasicAuthentication::make(
        username: $username,
        password: $password,
    );

    expect($basicAuthentication)->toBeInstanceOf(BasicAuthentication::class);
})->with([
    'encrypted' => fn () => [
        fake()->userName(),
        EncryptableText::make(fake()->password()),
    ],
    'strings' => fn () => [
        fake()->userName(),
        EncryptableText::make(fake()->password())->value(),
    ],
]);

it('can provide properties', function () {
    $username = fake()->userName();
    $password = fake()->password();
    $basicAuthentication = BasicAuthentication::make(
        username: $username,
        password: EncryptableText::make($password),
    );

    expect($basicAuthentication->username())->toBe($username);
    expect($basicAuthentication->password())->toBe($password);
});
