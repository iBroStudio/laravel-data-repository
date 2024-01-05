<?php

namespace IBroStudio\DataRepository\Concerns;

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Relations\MorphManyDataObjects;
use Illuminate\Database\Eloquent\Builder;

trait HasDataRepository
{
    public function initializeHasDataRepository()
    {
        $this->with[] = 'data_repository';
    }

    public function data_repository(?string $dataClass = null)
    {
        return $this->morphManyDataObjects(DataObject::class, 'referable')
            ->when($dataClass, function (Builder $query, string $dataClass) {
                $query->where('class', $dataClass);
            });
    }

    public function morphManyDataObjects($related, $name, $type = null, $id = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        [$type, $id] = $this->getMorphs($name, $type, $id);

        $table = $instance->getTable();

        $localKey = $localKey ?: $this->getKeyName();

        return new MorphManyDataObjects($instance->newQuery(), $this, $table.'.'.$type, $table.'.'.$id, $localKey);
    }
}
