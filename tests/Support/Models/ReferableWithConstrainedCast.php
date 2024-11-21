<?php

namespace IBroStudio\DataRepository\Tests\Support\Models;

use IBroStudio\DataRepository\Casts\DataObjectCast;
use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\DataRepository\Tests\Support\Database\Factories\ReferableFactory;
use IBroStudio\DataRepository\Tests\Support\DataObjects\OtherReferableData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferableWithConstrainedCast extends Model
{
    use HasDataRepository;
    use HasFactory;

    protected $fillable = ['dto_attribute'];

    protected function casts(): array
    {
        return [
            'dto_attribute' => DataObjectCast::class.':'.OtherReferableData::class,
        ];
    }

    protected static function newFactory(): ReferableFactory
    {
        return ReferableFactory::new();
    }
}
