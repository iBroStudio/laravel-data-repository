<?php

namespace IBroStudio\DataRepository\ValueObjects\Authentication;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use Illuminate\Support\Str;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class BasicAuthentication extends ValueObject implements Authentication
{
    private string $username;

    private EncryptableText $password;

    public function __construct(string $username, EncryptableText|string $password)
    {
        if (isset($this->username) || isset($this->password)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->username = $username;
        $this->password = $password instanceof EncryptableText
            ? $password
            : EncryptableText::make($password);

        $this->validate();
    }

    public function value(): string
    {
        return Str::of($this->username())
            ->append(':')
            ->append($this->password());
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password->decrypt();
    }

    protected function validate(): void
    {
        if ($this->username === '') {
            throw new InvalidArgumentException('Username cannot be empty.');
        }

        if ($this->password->value() === '') {
            throw new InvalidArgumentException('Password cannot be empty.');
        }
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password->value(),
        ];
    }

    public function toDecryptedArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password->decrypt(),
        ];
    }
}
