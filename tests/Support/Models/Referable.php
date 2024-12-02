<?php

namespace IBroStudio\DataRepository\Tests\Support\Models;

use IBroStudio\DataRepository\Casts\DataObjectCast;
use IBroStudio\DataRepository\Casts\ValueObjectCast;
use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\DataRepository\Tests\Support\Database\Factories\ReferableFactory;
use IBroStudio\DataRepository\ValueObjects\TimeDuration;
use IBroStudio\DataRepository\ValueObjects\Url;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referable extends Model
{
    use HasDataRepository;
    use HasFactory;

    protected $fillable = ['dto_attribute'];

    protected function casts(): array
    {
        return [
            'dto_attribute' => DataObjectCast::class,
            'object_value_property' => ValueObjectCast::class.':'.Url::class,
            'time_duration' => ValueObjectCast::class.':'.TimeDuration::class,
        ];
    }

    protected static function newFactory(): ReferableFactory
    {
        return ReferableFactory::new();
    }
}
