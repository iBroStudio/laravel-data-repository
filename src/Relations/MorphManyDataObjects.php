<?php

namespace IBroStudio\DataRepository\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use MichaelRubel\ValueObjects\ValueObject;
use Spatie\LaravelData\Data;

class MorphManyDataObjects extends MorphMany
{
    public function add(Data|ValueObject $data): Model
    {
        return parent::updateOrCreate(
            attributes: [
                'class' => get_class($data),
            ],
            values: [
                'values' => $data,
            ]
        );
    }

    public function values(): Data|ValueObject
    {
        return $this->query->firstOrFail()->values;
    }
}
