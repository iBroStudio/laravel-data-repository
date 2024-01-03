<?php

namespace IBroStudio\DataObjectsRepository\ValueObjects;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Stringable;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

class EncryptableText extends Text
{
    public static function encrypt(string|Stringable $value): static
    {
        return new static(
            Crypt::encryptString($value)
        );
    }

    public function decrypt(): string
    {
        return Crypt::decryptString($this->value);
    }
}
