<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

/**
 * @property-read array<mixed> $content
 */
class DependenciesJsonFile extends ValueObject
{
    /** @var array<mixed> */
    private array $content;

    public function __construct(string $value)
    {
        parent::__construct($value);

        $this->content = File::json($this->value);

        if (! Arr::exists($this->content, 'version')) {
            $this->content['version'] = '0.0.0';
        }
    }

    public function version(?SemanticVersion $version = null): SemanticVersion
    {
        if (! is_null($version)
            && $this->content['version'] !== $version->withoutPrefix()
        ) {
            $this->content['version'] = $version->withoutPrefix();

            File::put(
                path: $this->value,
                contents: json_encode($this->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            );
        }

        return SemanticVersion::from($this->content['version']);
    }

    public function data(?string $key = null): string|array|null
    {
        return is_null($key) ? $this->content : Arr::get($this->content, $key);
    }

    protected function validate(): void
    {
        parent::validate();

        if (! File::exists($this->value)) {
            throw ValidationException::withMessages(['File not found: '.$this->value]);
        }
    }
}
