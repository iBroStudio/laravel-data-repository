<?php

namespace IBroStudio\DataRepository\Tests\Support\Models;

use IBroStudio\DataRepository\Concerns\HasDataRepository;
use IBroStudio\DataRepository\Tests\Support\Database\Factories\ReferableFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referable extends Model
{
    use HasDataRepository;
    use HasFactory;

    protected static function newFactory()
    {
        return ReferableFactory::new();
    }
}
