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

    public function bytes(): int|string
    {
        return $this->value->numberOfBytes();
    }

    public function isEqualTo(string|IpAddress $compare): bool
    {
        return $this->value->isEqualTo(
            $compare instanceof IpAddress ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }

    public function isLessThanOrEqualTo(string|IpAddress $compare): bool
    {
        return $this->value->isLessThanOrEqualTo(
            $compare instanceof IpAddress ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }

    public function isLessThan(string|IpAddress $compare): bool
    {
        return $this->value->isLessThan(
            $compare instanceof IpAddress ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }

    public function isGreaterThanOrEqualTo(string|IpAddress $compare): bool
    {
        return $this->value->isGreaterThanOrEqualTo(
            $compare instanceof IpAddress ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }

    public function isGreaterThan(string|IpAddress $compare): bool
    {
        return $this->value->isGreaterThan(
            $compare instanceof IpAddress ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }
}
