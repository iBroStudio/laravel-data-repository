<?php

namespace IBroStudio\DataRepository\Concerns;

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Relations\MorphManyDataObjects;
use Illuminate\Database\Eloquent\Builder;

trait HasDataRepository
{
    public function initializeHasDataRepository(): void
    {
        $this->with[] = 'data_repository';
    }

    public function data_repository(?string $dataClass = null, ?array $valuesQuery = null): MorphManyDataObjects
    {
        // @phpstan-ignore-next-line
        return $this->morphManyDataObjects(DataObject::class, 'referable')
            // @phpstan-ignore-next-line
            ->when($dataClass, function (Builder $query, string $dataClass) {
                $query->where('class', $dataClass);
            })
            // @phpstan-ignore-next-line
            ->when($valuesQuery, function (Builder $query, array $valuesQuery) {
                foreach ($valuesQuery as $key => $value) {
                    $query->where('values->'.$key, $value);
                }
            });
    }

    public function morphManyDataObjects(string $related, string $name, ?string $type = null, ?string $id = null, ?string $localKey = null): MorphManyDataObjects
    {
        $instance = $this->newRelatedInstance($related);

        [$type, $id] = $this->getMorphs($name, $type, $id);

        $table = $instance->getTable();

        $localKey = $localKey ?: $this->getKeyName();

        return new MorphManyDataObjects($instance->newQuery(), $this, $table.'.'.$type, $table.'.'.$id, $localKey);
    }
}
