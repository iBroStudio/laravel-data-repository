<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Carbon\CarbonInterval;
use IBroStudio\DataRepository\Enums\TimeUnitEnum;
use Illuminate\Support\Str;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class TimeDuration extends ValueObject
{
    private CarbonInterval $duration;

    public function __construct(float|string $value, protected TimeUnitEnum|string $unit = TimeUnitEnum::MINUTES)
    {
        if (isset($this->duration)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        if (is_string($unit)) {
            $unit = TimeUnitEnum::from($unit);
        }

        if (Str::contains($value, ':')) {
            $this->fromString($value);
        } else {
            $this->fromFloat($value, $unit);
        }
    }

    private function fromFloat(float $value, TimeUnitEnum $unit): void
    {
        $this->duration = (new CarbonInterval(null))->add($unit->value, $value);
    }

    private function fromString(string $value): void
    {
        if (Str::substrCount($value, ':') > 1) {
            $this->duration = CarbonInterval::createFromFormat('H:i:s', $value);
        } else {
            $this->duration = CarbonInterval::createFromFormat('i:s', $value);
        }
    }

    public function value(): string
    {
        return (string) $this->duration->total($this->unit->value);
    }

    public function format(bool $short = false): string
    {
        return $this->duration->forHumans(['short' => $short]);
    }
}
