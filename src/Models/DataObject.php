<?php

namespace IBroStudio\DataRepository\Models;

use IBroStudio\DataRepository\Database\Factories\DataObjectFactory;
use IBroStudio\DataRepository\EloquentCasts\DataObjectAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DataObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'class', 'values',
    ];

    protected $casts = [
        'values' => DataObjectAttribute::class,
    ];

    public function referable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function newFactory(): Factory|DataObjectFactory
    {
        return DataObjectFactory::new();
    }
}
