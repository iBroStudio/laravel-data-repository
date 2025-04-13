<?php

namespace IBroStudio\DataRepository\ValueObjects;

use IBroStudio\DataRepository\Exceptions\EmptyValueObjectException;
use Illuminate\Contracts\Support\Arrayable;
use Throwable;

/**
 * @implements Arrayable<string, string>
 */
abstract class ValueObject implements Arrayable
{
    public readonly mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;

        $this->validate();
    }

    public static function from(mixed ...$values): static
    {
        // @phpstan-ignore-next-line
        return new static(...$values);
    }

    public static function fromOrNull(mixed ...$values): ?static
    {
        try {
            return static::from(...$values);
        } catch (Throwable) {
            return null;
        }
    }

    public function toArray(): array
    {
        return (array) $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function toJson(): false|string
    {
        return json_encode($this->toArray());
    }

    /** @return array<string, mixed> */
    public function properties(): array
    {
        return get_object_vars($this);
    }

    protected function validate(): void
    {
        if ($this->value === '') {
            throw EmptyValueObjectException::withMessages([class_basename(get_class($this)).' cannot be empty.']);
        }
    }
}
