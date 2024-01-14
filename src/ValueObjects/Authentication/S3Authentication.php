<?php

namespace IBroStudio\DataRepository\ValueObjects\Authentication;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use Illuminate\Support\Str;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class S3Authentication extends ValueObject implements Authentication
{
    private string $key;

    private EncryptableText $secret;

    public function __construct(string $key, EncryptableText|string $secret)
    {
        if (isset($this->key) || isset($this->secret)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->key = $key;
        $this->secret = $secret instanceof EncryptableText
            ? $secret
            : EncryptableText::make($secret);

        $this->validate();
    }

    public function value(): string
    {
        return Str::of($this->key())
            ->append(':')
            ->append($this->secret());
    }

    public function key(): string
    {
        return $this->key;
    }

    public function secret(): string
    {
        return $this->secret->decrypt();
    }

    protected function validate(): void
    {
        if ($this->key === '') {
            throw new InvalidArgumentException('Username cannot be empty.');
        }

        if ($this->secret->value() === '') {
            throw new InvalidArgumentException('Password cannot be empty.');
        }
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'secret' => $this->secret->value(),
        ];
    }

    public function toDecryptedArray(): array
    {
        return [
            'key' => $this->key,
            'secret' => $this->secret->decrypt(),
        ];
    }
}
