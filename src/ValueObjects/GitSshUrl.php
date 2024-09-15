<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Arr;
use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

class GitSshUrl extends Text
{
    /**
     * @var array<string, string>
     */
    protected array $split = [];

    /**
     * Create a new instance of the value object.
     */
    public function __construct(string|Stringable $value)
    {
        $this->before = function (): void {
            $this->split();
        };

        parent::__construct($value);
    }

    public function provider(): string
    {
        return $this->split['provider'];
    }

    public function username(): string
    {
        return $this->split['username'];
    }

    public function repository(): string
    {
        return $this->split['repository'];
    }

    /**
     * Get an array representation of the value object.
     */
    public function toArray(): array
    {
        return [
            'url' => $this->value(),
            'username' => $this->username(),
            'repository' => $this->repository(),
            'provider' => $this->provider(),
        ];
    }

    /**
     * Validate the url.
     */
    protected function validate(): void
    {
        if ($this->value() === '') {
            throw ValidationException::withMessages(['Url cannot be empty.']);
        }

        if (
            ! Arr::exists($this->split, 'provider') || $this->split['provider'] === ''
            || ! Arr::exists($this->split, 'username') || $this->split['username'] === ''
            || ! Arr::exists($this->split, 'repository') || $this->split['repository'] === ''
        ) {
            throw ValidationException::withMessages(['Your url is invalid.']);
        }
    }

    /**
     * Split the value.
     */
    protected function split(): void
    {
        if (
            preg_match(
                '/^git@(?<provider>.*)\..*:(?<username>.*)\/(?<repository>.*)\.git$/',
                $this->value(),
                $matches
            )
        ) {
            $this->split = Arr::only($matches, ['provider', 'username', 'repository']);
        }
    }
}
