<?php

namespace IBroStudio\DataRepository\ValueObjects;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
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
     * Validate the email.
     */
    protected function validate(): void
    {
        $validator = Validator::make(
            ['url' => $this->split],
            ['url' => $this->validationRules()],
        );

        if ($validator->fails()) {
            throw ValidationException::withMessages(['Your url is invalid.']);
        }
    }

    /**
     * Define the rules for email validator.
     */
    protected function validationRules(): array
    {
        return ['required', 'array:provider,username,repository'];
    }

    /**
     * Split the value by at symbol.
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
