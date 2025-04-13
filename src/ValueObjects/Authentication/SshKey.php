<?php

namespace IBroStudio\DataRepository\ValueObjects\Authentication;

use IBroStudio\DataRepository\Contracts\Authentication;
use IBroStudio\DataRepository\Exceptions\EmptyValueObjectException;
use IBroStudio\DataRepository\Rules\IsSshKeyValidRule;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\DataRepository\ValueObjects\ValueObject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SshKey extends ValueObject implements Authentication
{
    public readonly EncryptableText $key;

    public readonly ?EncryptableText $passphrase;

    public function __construct(
        public readonly string $user,
        EncryptableText|string $key,
        EncryptableText|string|null $passphrase = null)
    {
        try {
            $this->key = $key instanceof EncryptableText
                ? $key
                : EncryptableText::from($key);

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

        parent::__construct($this->user);
    }

    protected function validate(): void
    {
        parent::validate();

        $validator = Validator::make(
            ['ssh_key' => $this->key->decrypt()],
            ['ssh_key' => new IsSshKeyValidRule],
        );

        if ($validator->fails()) {
            throw ValidationException::withMessages(['Ssh key is not valid.']);
        }
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user,
            'key' => $this->key->value,
            'passphrase' => $this->passphrase?->value,
        ];
    }
}
