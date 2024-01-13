<?php

namespace IBroStudio\DataRepository\ValueObjects;

use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class SshAuthentication extends ValueObject
{
    private EncryptableText $privateKey;

    private ?EncryptableText $passphrase = null;

    public function __construct(EncryptableText|string $privateKey, EncryptableText|string|null $passphrase)
    {
        if (isset($this->privateKey) || isset($this->passphrase)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->privateKey = $privateKey instanceof EncryptableText
            ? $privateKey
            : EncryptableText::make($privateKey);

        if ($passphrase) {
            $this->passphrase = $passphrase instanceof EncryptableText
                ? $passphrase
                : EncryptableText::make($passphrase);
        }
    }

    public function value(): string
    {
        return $this->privateKey();
    }

    public function privateKey(): string
    {
        return $this->privateKey->decrypt();
    }

    public function passphrase(): ?string
    {
        return $this->passphrase?->decrypt();
    }

    public function toArray(): array
    {
        return [
            'privateKey' => $this->privateKey->value(),
            'passphrase' => $this->passphrase?->value(),
        ];
    }
}
