<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Darsyn\IP\Exception;
use Darsyn\IP\Version\Multi;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class IpAddress extends ValueObject
{
    protected Multi $value;

    public function __construct(string $value)
    {
        if (isset($this->value)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        try {
            $this->value = Multi::factory($value);
        } catch (Exception\InvalidIpAddressException $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function value(): string
    {
        return $this->value->getProtocolAppropriateAddress();
    }
}
