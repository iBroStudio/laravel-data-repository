<?php

namespace IBroStudio\DataObjectsRepository\Concerns;

use IBroStudio\DataObjectsRepository\Models\DataObject;
use IBroStudio\DataObjectsRepository\Relations\MorphOneDataObject;

trait HasDataRepository
{
    public function initializeHasDoRepository()
    {
        $this->with[] = 'data_object';
    }

    public function data_object()
    {
        return $this->morphOneDataObject(DataObject::class, 'referable');
    }

    public function morphOneDataObject($related, $name, $type = null, $id = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        [$type, $id] = $this->getMorphs($name, $type, $id);

        $table = $instance->getTable();

        $localKey = $localKey ?: $this->getKeyName();

        return new MorphOneDataObject($instance->newQuery(), $this, $table.'.'.$type, $table.'.'.$id, $localKey);
    }
}
