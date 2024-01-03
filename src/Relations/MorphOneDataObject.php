<?php

namespace IBroStudio\DataObjectsRepository\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\LaravelData\Data;

class MorphOneDataObject extends MorphOne
{
    public function add(Data $data): Model
    {
        $attributes = [
            'class' => get_class($data),
            'values' => $data,
        ];

        return parent::create($attributes);
    }
}
