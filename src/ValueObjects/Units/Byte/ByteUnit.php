<?php

namespace IBroStudio\DataRepository\ValueObjects\Units\Byte;

use ByteUnits;
use IBroStudio\DataRepository\Contracts\UnitValueContract;
use IBroStudio\DataRepository\Enums\ByteUnitEnum;
use IBroStudio\DataRepository\Formatters\ByteFormatter;
use IBroStudio\DataRepository\ValueObjects\ValueObject;
use Illuminate\Validation\ValidationException;

class ByteUnit extends ValueObject implements UnitValueContract
{
    protected ByteUnits\System $system;

    public function __construct(mixed $value)
    {
        if ($value instanceof ByteUnits\System) {
            $this->system = $value;
        } else {
            try {
                $this->system = ByteUnits\parse($value);
            } catch (ByteUnits\ParseException $e) {
                throw ValidationException::withMessages([$e->getMessage()]);
            }
        }

        parent::__construct(
            (int) $this->system->numberOfBytes()
        );
    }

    public function withUnit(?ByteUnitEnum $unit = null): string
    {
        return ByteFormatter::format($this->system->format($unit?->name));
    }

    public static function unit(): ?string
    {
        return ByteUnitEnum::B->getLabel();
    }

    public function convertIn(ByteUnitEnum $unit): string
    {
        return $this->withUnit($unit);
    }

    public function isEqualTo(string|ByteUnit $compare): bool
    {
        return $this->system->isEqualTo(
            $compare instanceof ByteUnit ? $compare->value : ByteUnits\parse($compare)
        );
    }

    public function isLessThanOrEqualTo(string|ByteUnit $compare): bool
    {
        return $this->system->isLessThanOrEqualTo(
            $compare instanceof ByteUnit ? $compare->value : ByteUnits\parse($compare)
        );
    }

    public function isLessThan(string|ByteUnit $compare): bool
    {
        return $this->system->isLessThan(
            $compare instanceof ByteUnit ? $compare->value : ByteUnits\parse($compare)
        );
    }

    public function isGreaterThanOrEqualTo(string|ByteUnit $compare): bool
    {
        return $this->system->isGreaterThanOrEqualTo(
            $compare instanceof ByteUnit ? $compare->value : ByteUnits\parse($compare)
        );
    }

    public function isGreaterThan(string|ByteUnit $compare): bool
    {
        return $this->system->isGreaterThan(
            $compare instanceof ByteUnit ? $compare->value : ByteUnits\parse($compare)
        );
    }
}
