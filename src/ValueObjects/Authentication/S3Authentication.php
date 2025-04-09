<?php

namespace IBroStudio\DataRepository\ValueObjects\Authentication;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\Exceptions\EmptyValueObjectException;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\DataRepository\ValueObjects\ValueObject;
use Illuminate\Support\Str;

class S3Authentication extends ValueObject implements Authentication
{
    public readonly EncryptableText $secret;

    public function __construct(public readonly string $key, EncryptableText|string $secret)
    {
        try {
            $this->secret = $secret instanceof EncryptableText
                ? $secret
                : EncryptableText::from($secret);

        } catch (EmptyValueObjectException $e) {
            throw EmptyValueObjectException::withMessages(['Secret cannot be empty.']);
        }

        parent::__construct(
            Str::of($this->key)
                ->append(':')
                ->append($this->secret->value)
                ->value()
        );
    }

    public function value(): string
    {
        return Str::of($this->key)
            ->append(':')
            ->append($this->secret->value);
    }

    protected function validate(): void
    {
        if ($this->key === '') {
            throw EmptyValueObjectException::withMessages(['Key cannot be empty.']);
        }
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'secret' => $this->secret->value,
        ];
    }
}
