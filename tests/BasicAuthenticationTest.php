<?php

use IBroStudio\DataRepository\ValueObjects\BasicAuthentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

it('can instantiate', function () {
    $basicAuthentication = BasicAuthentication::make(
        username: fake()->userName(),
        password: EncryptableText::make(fake()->password()),
    );

    expect($basicAuthentication)->toBeInstanceOf(BasicAuthentication::class);
});

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
