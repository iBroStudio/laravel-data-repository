<?php

namespace IBroStudio\DataObjectsRepository\Models;

use IBroStudio\DataObjectsRepository\Casts\DataObjectAttribute;
use IBroStudio\DataObjectsRepository\Database\Factories\DataObjectFactory;
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

    protected static function newFactory()
    {
        return DataObjectFactory::new();
    }
}
