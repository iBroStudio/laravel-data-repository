<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class VersionedComposerJson extends ValueObject
{
    protected string|Stringable $value;

    protected array $content;

    public function __construct(string|Stringable $value)
    {
        if (isset($this->value)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->value = $value;

        $this->validate();

        $this->content = File::json($this->value());

        if (! Arr::exists($this->content, 'version')) {
            $this->content['version'] = '0.0.0';
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function version(?SemanticVersion $version = null): SemanticVersion
    {
        if (! is_null($version)
            && $this->content['version'] !== $version->withoutPrefix()->value()
        ) {
            $this->content['version'] = $version->withoutPrefix()->value();

            File::put(
                path: $this->value(),
                contents: json_encode($this->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            );
        }

        return SemanticVersion::make($this->content['version']);
    }

    protected function validate(): void
    {
        if ($this->value() === '') {
            throw ValidationException::withMessages(['No file provided']);
        }

        if (! File::exists($this->value())) {
            throw ValidationException::withMessages(['File not found: '.$this->value()]);
        }
    }
}
