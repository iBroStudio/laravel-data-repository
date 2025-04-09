<?php

namespace IBroStudio\DataRepository\ValueObjects;

use IBroStudio\DataRepository\Enums\SemanticVersionSegments;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;

class SemanticVersion extends ValueObject
{
    private int $major;

    private int $minor;

    private int $patch;

    private string $prefix = '';

    public function __construct(mixed $value)
    {
        preg_match(
            '/(?<prefix>v.?)?(?<major>\d+)\.(?<minor>\d+)\.(?<patch>\d+)/',
            $value,
            $matches
        );

        if (! count($matches)) {
            throw ValidationException::withMessages(['Version is not valid.']);
        }

        $this->major = (int) $matches['major'];
        $this->minor = (int) $matches['minor'];
        $this->patch = (int) $matches['patch'];
        $this->prefix = $matches['prefix'];

        parent::__construct($value);
    }

    public function withoutPrefix(): string
    {
        return Str::after($this->value, $this->prefix);
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

        return self::from(
            Str::of(
                Arr::join(
                    [$incremented->major, $incremented->minor, $incremented->patch],
                    '.'
                )
            )
                ->when(Str::length($this->prefix), function (Stringable $string) {
                    return $string->prepend($this->prefix);
                })
                ->toString()
        );
    }
}
