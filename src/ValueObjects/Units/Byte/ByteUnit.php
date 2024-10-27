<?php

namespace IBroStudio\DataRepository\ValueObjects\Units\Byte;

use ByteUnits;
use IBroStudio\DataRepository\Contracts\UnitValueContract;
use IBroStudio\DataRepository\Enums\ByteUnitEnum;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class ByteUnit extends ValueObject implements UnitValueContract
{
    protected ByteUnits\System $value;

    final public function __construct(int|string|float|ByteUnits\System $value)
    {
        if (isset($this->value)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        if ($value instanceof ByteUnits\System) {
            $this->value = $value;
        } else {
            try {
                $this->value = ByteUnits\parse($value);
            } catch (ByteUnits\ParseException $e) {
                throw ValidationException::withMessages([$e->getMessage()]);
            }
        }
    }

    public function parsed(): ByteUnits\System
    {
        return $this->value;
    }

    public function value(?ByteUnitEnum $unit = null): string
    {
        $formated = $this->value->format($unit?->name);
        $unit = Str::substr($formated, -2);

        return Str::of($formated)
            ->chopEnd($unit)
            ->rtrim('0')
            ->chopEnd('.')
            ->append($unit)
            ->toString();
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

    public static function unit(): ?string
    {
        return 'B';
    }
}
