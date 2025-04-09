<?php

namespace IBroStudio\DataRepository\Relations;

use IBroStudio\DataRepository\ValueObjects\ValueObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\LaravelData\Data;

class MorphManyDataObjects extends MorphMany
{
    public function add(Data|ValueObject $data, array $valuesAttributes = []): Model
    {
        return parent::updateOrCreate(
            attributes: [
                ...$valuesAttributes,
                'class' => get_class($data),
            ],
            values: [
                'values' => $data,
            ]
        );
    }

    public function values(): Data|ValueObject
    {
        // @phpstan-ignore-next-line
        return $this->query->firstOrFail()->values;
    }
}
