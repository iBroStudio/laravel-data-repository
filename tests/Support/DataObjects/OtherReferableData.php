<?php

namespace IBroStudio\DataRepository\Tests\Support\DataObjects;

use Spatie\LaravelData\Data;

class OtherReferableData extends Data
{
    public function __construct(
        public string $name,
    ) {
    }
}
