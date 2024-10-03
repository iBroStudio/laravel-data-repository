<?php

namespace IBroStudio\DataRepository\ValueObjects;

use ByteUnits;
use IBroStudio\DataRepository\Enums\ByteUnitEnum;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class ByteUnit extends ValueObject
{
    protected ByteUnits\System $value;

    public function __construct(string $value)
    {
        if (isset($this->value)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        try {
            $this->value = ByteUnits\parse($value);
        } catch (ByteUnits\ParseException $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function parsed(): ByteUnits\System
    {
        return $this->value;
    }

    public function value(?ByteUnitEnum $unit = null): string
    {
        return $this->value->format($unit?->name);
    }

    public function bytes(): int|string
    {
        return $this->value->numberOfBytes();
    }

    public function isEqualTo(string|ByteUnit $compare): bool
    {
        return $this->value->isEqualTo(
            $compare instanceof ByteUnit ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }

    public function isLessThanOrEqualTo(string|ByteUnit $compare): bool
    {
        return $this->value->isLessThanOrEqualTo(
            $compare instanceof ByteUnit ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }

    public function isLessThan(string|ByteUnit $compare): bool
    {
        return $this->value->isLessThan(
            $compare instanceof ByteUnit ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }

    public function isGreaterThanOrEqualTo(string|ByteUnit $compare): bool
    {
        return $this->value->isGreaterThanOrEqualTo(
            $compare instanceof ByteUnit ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }

    public function isGreaterThan(string|ByteUnit $compare): bool
    {
        return $this->value->isGreaterThan(
            $compare instanceof ByteUnit ? $compare->parsed() : ByteUnits\parse($compare)
        );
    }
}
