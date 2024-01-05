<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class Timecode extends ValueObject
{
    protected int $hours;

    protected int $minutes;

    protected float $seconds;

    public function __construct(float|string $value)
    {
        if (isset($this->hours)
            || isset($this->minutes)
            || isset($this->seconds)
        ) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        if (Str::contains($value, ':')) {
            $this->fromString($value);
        } else {
            $this->fromFloat($value);
        }

        $this->validate();
    }

    private function fromFloat(float $value): void
    {
        $this->seconds = $value;
        $this->hours = floor($this->seconds / 3600);
        $this->seconds -= $this->hours * 3600;
        $this->minutes = floor($this->seconds / 60);
        $this->seconds -= $this->minutes * 60;
        $this->seconds = round($this->seconds, 6);
    }

    private function fromString(string $value): void
    {
        [$this->hours, $this->minutes, $this->seconds] = explode(':', $value);
    }

    protected function validate(): void
    {
        if ($this->value() === '') {
            throw ValidationException::withMessages(['Time position cannot be empty.']);
        }

        if (! is_float($this->seconds)) {
            throw ValidationException::withMessages(['Seconds must be float']);
        }

        if ($this->seconds > 59) {
            throw ValidationException::withMessages(['Seconds can not be greater than 59']);
        }

        if (! is_int($this->minutes)) {
            throw ValidationException::withMessages(['Seconds must be integer']);
        }

        if ($this->minutes > 59) {
            throw ValidationException::withMessages(['Minutes can not be greater than 59']);
        }

        if (! is_int($this->hours)) {
            throw ValidationException::withMessages(['Hours must be integer']);
        }
    }

    public function value(): string
    {
        return Str::of($this->hours)
            ->padLeft(2, 0)
            ->append(':')
            ->append(
                Str::padLeft($this->minutes, 2, 0)
            )
            ->append(':')
            ->append(
                Str::of($this->seconds)
                    ->before('.')
                    ->padLeft(2, 0)
            )
            ->append('.')
            ->append(
                Str::of($this->seconds)
                    ->after('.')
                    ->padRight(6, 0)
            );
    }

    public function seconds(): float
    {
        return $this->seconds + ($this->minutes * 60) + ($this->hours * 3600);
    }
}
