<?php

namespace IBroStudio\DataRepository\Data;

use Spatie\LaravelData\Data;

class VatNumberAuthenticationData extends Data
{
    public function __construct(
        public string $name,
        public string $vatNumber,
        public string $address,
        public string $countryCode,
    ) {}

    public static function fromViesApi(\stdClass $response): self
    {
        return new self(
            name: $response->name,
            vatNumber: $response->vatNumber,
            address: $response->address,
            countryCode: $response->countryCode
        );
    }
}
