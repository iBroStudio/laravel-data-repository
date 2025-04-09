<?php

namespace IBroStudio\DataRepository\ValueObjects\Authentication;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\Exceptions\EmptyValueObjectException;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\DataRepository\ValueObjects\ValueObject;

class SshAuthentication extends ValueObject implements Authentication
{
    public readonly EncryptableText $privateKey;

    public readonly ?EncryptableText $passphrase;

    public function __construct(
        public readonly string $username,
        EncryptableText|string $privateKey,
        EncryptableText|string|null $passphrase)
    {
        try {
            $this->privateKey = $privateKey instanceof EncryptableText
                ? $privateKey
                : EncryptableText::from($privateKey);

        } catch (EmptyValueObjectException $e) {
            throw EmptyValueObjectException::withMessages(['Private key cannot be empty.']);
        }

        if ($passphrase) {
            $this->passphrase = $passphrase instanceof EncryptableText
                ? $passphrase
                : EncryptableText::from($passphrase);
        } else {
            $this->passphrase = null;
        }

        parent::__construct($this->username);
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'privateKey' => $this->privateKey->value,
            'passphrase' => $this->passphrase?->value,
        ];
    }
}
