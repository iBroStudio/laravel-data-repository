<?php

use IBroStudio\DataRepository\ValueObjects\Authentication;
use IBroStudio\DataRepository\ValueObjects\BasicAuthentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\DataRepository\ValueObjects\SshAuthentication;

it('can instantiate', function (BasicAuthentication|SshAuthentication $auth) {
    $authentication = Authentication::make($auth);

    expect($authentication)->toBeInstanceOf(Authentication::class);
})->with([
    'basic' => fn () => BasicAuthentication::make(
        username: fake()->userName(),
        password: EncryptableText::make(fake()->password()),
    ),
    'ssh' => fn () => SshAuthentication::make(
        privateKey: EncryptableText::make(fake()->macAddress()),
        passphrase: EncryptableText::make(fake()->password()),
    ),
]);
