<?php

namespace IBroStudio\DataRepository\Tests\Support\DataObjects;

use Spatie\LaravelData\Data;

class ReferableData extends Data
{
    public function __construct(
        public string $name,
    ) {
    }
}
