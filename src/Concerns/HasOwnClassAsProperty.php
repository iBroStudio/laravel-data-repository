<?php

namespace IBroStudio\DataRepository\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasOwnClassAsProperty
{
    public static string $defaultClassPropertyName = 'class';

    public static function getClassPropertyName(): string
    {
        /** @var string $classPropertyName */
        return static::$classPropertyName ?? static::$defaultClassPropertyName;
    }

    public static function bootHasOwnClassAsProperty(): void
    {
        static::addGlobalScope('class', function (Builder $builder) {
            // dd(static::getClassPropertyName(), get_called_class());
            $builder->where(static::getClassPropertyName(), get_called_class());
        });

        static::creating(function (Model $model) {
            $model->setAttribute(
                key: static::getClassPropertyName(),
                value: get_called_class()
            );
        });
    }
}
