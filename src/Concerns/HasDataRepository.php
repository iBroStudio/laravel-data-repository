<?php

namespace IBroStudio\DataRepository\Concerns;

use IBroStudio\DataRepository\EloquentCasts\DataObjectCast;
use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Relations\MorphManyDataObjects;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait HasDataRepository
{
    public function initializeHasDataRepository(): void
    {
        $this->with[] = 'data_repository';
    }

    public static function bootHasDataRepository()
    {
        static::creating(function ($model) {
            Arr::map($model->getCasts(), function (string $value, string $attribute) use ($model) {
                if (Str::startsWith($value, DataObjectCast::class)) {
                    if (! is_null($model->{$attribute})) {
                        Cache::put($attribute, $model->{$attribute});
                        $model->{$attribute} = null;
                    }
                }
            });
        });

        static::created(function ($model) {
            Arr::map($model->getCasts(), function (string $value, string $attribute) use ($model) {
                if (Cache::has($attribute)) {
                    $model->{$attribute} = $model->data_repository()->add(Cache::pull($attribute))->id;
                    $model->save();
                }
            });
        });

        static::updating(function ($model) {
            Arr::map($model->getCasts(), function (string $value, string $attribute) use ($model) {
                if (Str::startsWith($value, DataObjectCast::class)) {
                    if (! is_null($model->{$attribute})) {
                        $model->{$attribute} = $model->data_repository()->add($model->{$attribute})->id;
                    }
                }
            });
        });

        static::deleted(function ($model) {
            $model->data_repository()->delete();
        });
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
