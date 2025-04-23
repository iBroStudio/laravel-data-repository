<?php

namespace IBroStudio\DataRepository\Tests\Support\Models;

use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\DataRepository\Concerns\HasOwnClassAsProperty;
use IBroStudio\DataRepository\EloquentCasts\DataObjectCast;
use IBroStudio\DataRepository\EloquentCasts\ValueObjectCast;
use IBroStudio\DataRepository\Tests\Support\Database\Factories\ReferableFactory;
use IBroStudio\DataRepository\ValueObjects\Domain;
use IBroStudio\DataRepository\ValueObjects\TimeDuration;
use IBroStudio\DataRepository\ValueObjects\Url;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referable extends Model
{
    use HasDataRepository;
    use HasFactory;
    use HasOwnClassAsProperty;

    protected $fillable = ['dto_attribute'];

    protected function casts(): array
    {
        return [
            'dto_attribute' => DataObjectCast::class,
            'object_value_property' => ValueObjectCast::class.':'.Url::class,
            'time_duration' => ValueObjectCast::class.':'.TimeDuration::class,
            'domain' => ValueObjectCast::class.':'.Domain::class,
        ];
    }

    protected static function newFactory(): ReferableFactory
    {
        return ReferableFactory::new();
    }
}
