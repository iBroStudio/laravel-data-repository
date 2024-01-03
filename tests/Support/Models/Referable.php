<?php

namespace IBroStudio\DataObjectsRepository\Tests\Support\Models;

use IBroStudio\DataObjectsRepository\Concerns\HasDataRepository;
use IBroStudio\DataObjectsRepository\Tests\Support\Database\Factories\ReferableFactory;
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
