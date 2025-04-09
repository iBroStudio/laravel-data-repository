<?php

namespace IBroStudio\DataRepository\ValueObjects\Authentication;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\Exceptions\EmptyValueObjectException;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\DataRepository\ValueObjects\ValueObject;
use Illuminate\Support\Str;

class BasicAuthentication extends ValueObject implements Authentication
{
    public readonly EncryptableText $password;

    public function __construct(public readonly string $username, EncryptableText|string $password)
    {
        try {
            $this->password = $password instanceof EncryptableText
                ? $password
                : EncryptableText::from($password);

        } catch (EmptyValueObjectException $e) {
            throw EmptyValueObjectException::withMessages(['Password cannot be empty.']);
        }

        parent::__construct(
            Str::of($this->username)
                ->append(':')
                ->append($this->password->value)
                ->value()
        );
    }

    protected function validate(): void
    {
        if ($this->username === '') {
            throw EmptyValueObjectException::withMessages(['Username cannot be empty.']);
        }
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password->value,
        ];
    }
}
