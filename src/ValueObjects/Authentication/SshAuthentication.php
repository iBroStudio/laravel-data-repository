<?php

namespace IBroStudio\DataRepository\ValueObjects\Authentication;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class SshAuthentication extends ValueObject implements Authentication
{
    private string $username;

    private EncryptableText $privateKey;

    private ?EncryptableText $passphrase = null;

    public function __construct(
        string $username,
        EncryptableText|string $privateKey,
        EncryptableText|string|null $passphrase)
    {
        if (isset($this->username) || isset($this->privateKey) || isset($this->passphrase)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->username = $username;

        $this->privateKey = $privateKey instanceof EncryptableText
            ? $privateKey
            : EncryptableText::make($privateKey);

        if ($passphrase) {
            $this->passphrase = $passphrase instanceof EncryptableText
                ? $passphrase
                : EncryptableText::make($passphrase);
        }

        $this->validate();
    }

    public function value(): string
    {
        return $this->username;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function privateKey(): string
    {
        return $this->privateKey->decrypt();
    }

    public function passphrase(): ?string
    {
        return $this->passphrase?->decrypt();
    }

    protected function validate(): void
    {
        if ($this->username === '') {
            throw new InvalidArgumentException('Username cannot be empty.');
        }
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'privateKey' => $this->privateKey->value(),
            'passphrase' => $this->passphrase?->value(),
        ];
    }

    public function toDecryptedArray(): array
    {
        return [
            'username' => $this->username,
            'privateKey' => $this->privateKey->decrypt(),
            'passphrase' => $this->passphrase?->decrypt(),
        ];
    }
}
