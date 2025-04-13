<?php

use IBroStudio\DataRepository\Exceptions\EmptyValueObjectException;
use IBroStudio\DataRepository\ValueObjects\Authentication\SshKey;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;

it('can instantiate SshKey object value', function (
    string $user,
    EncryptableText|string $key,
    EncryptableText|string|null $passphrase) {
    $ssh_key = SshKey::from(
        user: $user,
        key: $key,
        passphrase: $passphrase,
    );

    expect($ssh_key)->toBeInstanceOf(SshKey::class);
})->with([
    'encrypted' => fn () => [
        fake()->userName(),
        EncryptableText::from(fake()->sshKey()),
        EncryptableText::from(fake()->password()),
    ],
    'strings' => fn () => [
        fake()->userName(),
        fake()->sshKey(),
        fake()->password(),
    ],
    'nullable' => fn () => [
        fake()->userName(),
        EncryptableText::from(fake()->sshKey()),
        null,
    ],
]);

it('debug', function () {
    dd(
        SshKey::from(
            user: fake()->userName(),
            key: fake()->sshKey(),
        )
    );
});
it('can validate SshKey object value key', function () {
    SshKey::from(
        user: fake()->userName(),
        key: '',
        passphrase: EncryptableText::from(fake()->password()),
    );
})->throws(EmptyValueObjectException::class, 'Private key cannot be empty.');

it('can return SshKey object value single property', function () {
    $user = fake()->userName();
    $key = fake()->sshKey();
    $passphrase = fake()->password();
    $ssh_key = SshKey::from(
        user: $user,
        key: $key,
        passphrase: $passphrase,
    );

    expect($ssh_key->user)->toBe($user)
        ->and($ssh_key->key->decrypt())->toBe($key)
        ->and($ssh_key->passphrase->decrypt())->toBe($passphrase);
});

it('can return SshKey object value properties', function () {
    $user = fake()->userName();
    $key = fake()->sshKey();
    $passphrase = fake()->password();
    $ssh_key = SshKey::from(
        user: $user,
        key: $key,
        passphrase: $passphrase,
    );

    expect(
        $ssh_key->properties()
    )->toMatchArray([
        'value' => $user,
        'user' => $user,
        'key' => $ssh_key->key,
        'passphrase' => $ssh_key->passphrase,
    ]);
});
