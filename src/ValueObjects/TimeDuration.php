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

    public function __construct(float|string $value, protected TimeUnitEnum|string|null $unit = null)
    {
        if (isset($this->duration)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        if (! $this->unit instanceof TimeUnitEnum) {
            $this->unit = is_string($this->unit) ?
                TimeUnitEnum::from($this->unit) : TimeUnitEnum::MINUTES;
        }

        if (Str::contains($value, ':')) {
            $this->fromString($value);
        } else {
            $this->fromFloat($value);
        }
    }

    private function fromFloat(float $value): void
    {
        $this->duration = (new CarbonInterval(null))->add($this->unit->value, $value);
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
