<?php

use IBroStudio\DataRepository\ValueObjects\Authentication\SshAuthentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

it('can instantiate', function (
    string $username,
    EncryptableText|string $privateKey,
    EncryptableText|string|null $passphrase) {
    $sshAuthentication = SshAuthentication::make(
        username: $username,
        privateKey: $privateKey,
        passphrase: $passphrase,
    );

    expect($sshAuthentication)->toBeInstanceOf(SshAuthentication::class);
})->with([
    'encrypted' => fn () => [
        fake()->userName(),
        EncryptableText::make(fake()->macAddress()),
        EncryptableText::make(fake()->password()),
    ],
    'strings' => fn () => [
        fake()->userName(),
        EncryptableText::make(fake()->macAddress())->value(),
        EncryptableText::make(fake()->password())->value(),
    ],
    'nullable' => fn () => [
        fake()->userName(),
        EncryptableText::make(fake()->macAddress()),
        null,
    ],
]);

it('can provide properties', function () {
    $privateKey = fake()->macAddress();
    $passphrase = fake()->password();
    $sshAuthentication = SshAuthentication::make(
        username: fake()->userName(),
        privateKey: EncryptableText::make($privateKey),
        passphrase: EncryptableText::make($passphrase),
    );

    expect($sshAuthentication->privateKey())->toBe($privateKey);
    expect($sshAuthentication->passphrase())->toBe($passphrase);
});
