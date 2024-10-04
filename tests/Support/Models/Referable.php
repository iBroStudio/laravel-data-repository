<?php

namespace IBroStudio\DataRepository\Tests\Support\Models;

use IBroStudio\DataRepository\Casts\DataObjectCast;
use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\DataRepository\Tests\Support\Database\Factories\ReferableFactory;
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
        ];
    }

    protected static function newFactory(): ReferableFactory
    {
        return ReferableFactory::new();
    }
}
