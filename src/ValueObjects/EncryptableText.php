<?php

namespace IBroStudio\DataRepository\ValueObjects;

use IBroStudio\DataRepository\Rules\Encrypted;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

final class EncryptableText extends Text
{
    public static function make(mixed ...$values): static
    {
        $value = current($values);

        return new self(
            self::isEncrypted($value)
                ? $value
                : Crypt::encryptString($value)
        );
    }

    public function decrypt(): string
    {
        return Crypt::decryptString($this->value);
    }

    protected function validate(): void
    {
        if ($this->value() === '') {
            throw new InvalidArgumentException('Value cannot be empty.');
        }

        if (! self::isEncrypted($this->value())) {
            throw new InvalidArgumentException('Value must be encrypted.');
        }
    }

    private static function isEncrypted(string $value): bool
    {
        $validator = Validator::make(['value' => $value], [
            'value' => new Encrypted,
        ]);

        return ! $validator->fails();
    }
}
