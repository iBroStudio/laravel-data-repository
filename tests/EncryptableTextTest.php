<?php

use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

it('can instantiate EncryptableText', function () {
    $encryptableText = EncryptableText::make(fake()->word());

    expect($encryptableText)->toBeInstanceOf(EncryptableText::class);
});

it('can encrypt EncryptableText', function () {
    $encryptableText = EncryptableText::encrypt(fake()->word());

    expect(isEncrypted($encryptableText))->toBeTrue();
});

it('can decrypt EncryptableText', function () {
    $text = fake()->word();
    $encryptableText = EncryptableText::encrypt($text);

    expect($encryptableText->decrypt())->toEqual($text);
});

function isEncrypted(string $encryptedText)
{
    try {
        Crypt::decryptString($encryptedText);

        return true;
    } catch (DecryptException $e) {
        return -1;
    } catch (Exception $e) {
        return false;
    }
}
