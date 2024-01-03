<?php

namespace IBroStudio\DataObjectsRepository\Normalizers;

use IBroStudio\DataObjectsRepository\Models\DataObject;
use Illuminate\Support\Str;
use Spatie\LaravelData\Normalizers\Normalizer;

class DataRepositoryNormalizer implements Normalizer
{
    public function normalize(mixed $value): ?array
    {
        return null;
        if (! $value instanceof DataObject) {
            return null;
        }
        logdesk($value->getAttribute('id'));

        return null;

        return json_decode($value->values, true);

        $properties = $value->toArray();

        foreach ($value->getDates() as $key) {
            if (isset($properties[$key])) {
                $properties[$key] = $value->getAttribute($key);
            }
        }

        foreach ($value->getCasts() as $key => $cast) {
            if ($this->isDateCast($cast)) {
                if (isset($properties[$key])) {
                    $properties[$key] = $value->getAttribute($key);
                }
            }
        }

        foreach ($value->getRelations() as $key => $relation) {
            $key = $value::$snakeAttributes ? Str::snake($key) : $key;

            if (isset($properties[$key])) {
                $properties[$key] = $relation;
            }
        }

        return $properties;
    }

    protected function isDateCast(string $cast): bool
    {
        return in_array($cast, [
            'date',
            'datetime',
            'immutable_date',
            'immutable_datetime',
            'custom_datetime',
            'immutable_custom_datetime',
        ]);
    }
}
