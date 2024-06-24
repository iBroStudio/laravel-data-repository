<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

class HashedPassword extends Text
{
    public function value(): string
    {
        return Hash::make($this->value);
    }

    protected function validate(): void
    {
        if ($this->value === '') {
            throw new InvalidArgumentException('Password cannot be empty.');
        }

        $validator = Validator::make(['password' => $this->value], [
            'password' => Password::default(),
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->messages()->first('password'));
        }
    }
}
