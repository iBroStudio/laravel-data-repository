<?php

namespace IBroStudio\DataRepository\ValueObjects;

use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class Authentication extends ValueObject
{
    private BasicAuthentication|SshAuthentication $auth;

    public function __construct(BasicAuthentication|SshAuthentication|array $auth)
    {
        if (isset($this->auth)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }
        if (is_array($auth)) {
            //dd($auth);
        }

        $this->auth = is_array($auth)
            ? $auth['class']::make(...$auth['values'])
            : $auth;
    }

    public function value(): string
    {
        return $this->auth->value();
    }

    public function toArray(): array
    {
        return [
            'auth' => [
                'class' => $this->auth::class,
                'values' => $this->auth->toArray(),
            ],
        ];
    }
}
