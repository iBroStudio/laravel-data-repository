<?php

namespace IBroStudio\DataRepository\Tests\Support\DataObjects;

use IBroStudio\DataRepository\Transformers\DataObjectTransformer;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

class WithTransformableData extends Data
{
    public function __construct(
        public string $name,
        #[WithTransformer(DataObjectTransformer::class, key: 'name')]
        public OtherReferableData $otherData,
    ) {}
}
