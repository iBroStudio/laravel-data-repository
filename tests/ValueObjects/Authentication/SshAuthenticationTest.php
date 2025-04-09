<?php

use IBroStudio\DataRepository\Exceptions\EmptyValueObjectException;
use IBroStudio\DataRepository\ValueObjects\Authentication\SshAuthentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

it('can instantiate SshAuthentication object value', function (
    string $username,
    EncryptableText|string $privateKey,
    EncryptableText|string|null $passphrase) {
    $sshAuthentication = SshAuthentication::from(
        username: $username,
        privateKey: $privateKey,
        passphrase: $passphrase,
    );

    expect($sshAuthentication)->toBeInstanceOf(SshAuthentication::class);
})->with([
    'encrypted' => fn () => [
        fake()->userName(),
        EncryptableText::from(fake()->macAddress()),
        EncryptableText::from(fake()->password()),
    ],
    'strings' => fn () => [
        fake()->userName(),
        fake()->macAddress(),
        fake()->password(),
    ],
    'nullable' => fn () => [
        fake()->userName(),
        EncryptableText::from(fake()->macAddress()),
        null,
    ],
]);

it('can validate SshAuthentication object value Private key', function () {
    SshAuthentication::from(
        username: fake()->userName(),
        privateKey: '',
        passphrase: EncryptableText::from(fake()->password()),
    );
})->throws(EmptyValueObjectException::class, 'Private key cannot be empty.');

it('can return SshAuthentication object value single property', function () {
    $username = fake()->userName();
    $privateKey = fake()->macAddress();
    $passphrase = fake()->password();
    $SshAuthentication = SshAuthentication::from(
        username: $username,
        privateKey: $privateKey,
        passphrase: $passphrase,
    );

    expect($SshAuthentication->username)->toBe($username)
        ->and($SshAuthentication->privateKey->decrypt())->toBe($privateKey)
        ->and($SshAuthentication->passphrase->decrypt())->toBe($passphrase);
});

it('can return SshAuthentication object value properties', function () {
    $username = fake()->userName();
    $privateKey = fake()->macAddress();
    $passphrase = fake()->password();
    $SshAuthentication = SshAuthentication::from(
        username: $username,
        privateKey: $privateKey,
        passphrase: $passphrase,
    );

    expect(
        $SshAuthentication->properties()
    )->toMatchArray([
        'value' => $username,
        'username' => $username,
        'privateKey' => $SshAuthentication->privateKey,
        'passphrase' => $SshAuthentication->passphrase,
    ]);
});
