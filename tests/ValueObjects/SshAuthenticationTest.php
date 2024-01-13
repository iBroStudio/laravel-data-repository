<?php

use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\DataRepository\ValueObjects\SshAuthentication;

it('can instantiate', function (EncryptableText|string $privateKey, EncryptableText|string|null $passphrase) {
    $sshAuthentication = SshAuthentication::make(
        privateKey: $privateKey,
        passphrase: $passphrase,
    );

    expect($sshAuthentication)->toBeInstanceOf(SshAuthentication::class);
})->with([
    'encrypted' => fn () => [
        EncryptableText::make(fake()->macAddress()),
        EncryptableText::make(fake()->password()),
    ],
    'strings' => fn () => [
        EncryptableText::make(fake()->macAddress())->value(),
        EncryptableText::make(fake()->password())->value(),
    ],
    'nullable' => fn () => [
        EncryptableText::make(fake()->macAddress()),
        null,
    ],
]);

it('can provide properties', function () {
    $privateKey = fake()->macAddress();
    $passphrase = fake()->password();
    $sshAuthentication = SshAuthentication::make(
        privateKey: EncryptableText::make($privateKey),
        passphrase: EncryptableText::make($passphrase),
    );

    expect($sshAuthentication->privateKey())->toBe($privateKey);
    expect($sshAuthentication->passphrase())->toBe($passphrase);
});
