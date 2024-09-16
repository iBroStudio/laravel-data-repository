<?php

namespace IBroStudio\DataRepository\ValueObjects;

use IBroStudio\DataRepository\Enums\SemanticVersionSegments;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class SemanticVersion extends ValueObject
{
    private int $major;

    private int $minor;

    private int $patch;

    private string $prefix = '';

    private bool $withPrefix = true;

    public function __construct(string $value)
    {
        if (isset($this->major)
            || isset($this->minor)
            || isset($this->patch)
        ) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        if (
            preg_match(
                '/(?<prefix>v.?)?(?<major>\d+)\.(?<minor>\d+)\.(?<patch>\d+)/',
                $value,
                $matches
            )
        ) {
            $this->major = (int) $matches['major'];
            $this->minor = (int) $matches['minor'];
            $this->patch = (int) $matches['patch'];
            $this->prefix = $matches['prefix'];
        }

        $this->validate();
    }

    /**
     * @throws ValidationException
     */
    protected function validate(): void
    {
        if (! isset($this->major) || ! isset($this->minor) || ! isset($this->patch)) {
            throw ValidationException::withMessages(['Value is not a valid semantic version.']);
        }
    }

    public function withoutPrefix(): self
    {
        $this->withPrefix = false;

        return $this;
    }

    public function value(): string
    {
        return Str::of(
            Arr::join(
                [$this->major, $this->minor, $this->patch],
                '.'
            )
        )
            ->when($this->withPrefix, function (Stringable $string) {
                return $string->prepend($this->prefix);
            }, function () {
                $this->withPrefix = true; // reset the property
            });
    }

    public function increment(SemanticVersionSegments $segment): static
    {
        $incremented = clone $this;

        if ($segment === SemanticVersionSegments::PATCH) {
            $incremented->patch++;
        } elseif ($segment === SemanticVersionSegments::MINOR) {
            $incremented->minor++;
            $incremented->patch = 0;
        } elseif ($segment === SemanticVersionSegments::MAJOR) {
            $incremented->major++;
            $incremented->minor = 0;
            $incremented->patch = 0;
        }

        return $incremented;
    }
}
