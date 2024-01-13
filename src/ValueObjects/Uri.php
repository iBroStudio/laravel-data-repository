<?php

namespace IBroStudio\DataRepository\ValueObjects;

use GuzzleHttp\Psr7\Uri as GuzzleUri;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

class Uri extends ValueObject
{
    private GuzzleUri $uri;

    public function __construct(string $value)
    {
        if (isset($this->uri)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->uri = new GuzzleUri($value);

        //$this->validate();
    }

    public function uri(): GuzzleUri
    {
        return $this->uri;
    }

    public function value(): string
    {
        return $this->uri->__toString();
    }
}
