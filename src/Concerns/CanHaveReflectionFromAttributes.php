<?php

namespace IBroStudio\DataRepository\Concerns;

use ReflectionClass;
use Spatie\LaravelData\Attributes\DataCollectionOf;

trait CanHaveReflectionFromAttributes
{
    public function getReflectionFromAttributes(array $attributes): ?ReflectionClass
    {
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === DataCollectionOf::class) {
                return new ReflectionClass($attribute->getArguments()[0]);
            }
        }

        return null;
    }
}
