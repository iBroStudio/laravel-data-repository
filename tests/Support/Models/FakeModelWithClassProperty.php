<?php

namespace IBroStudio\DataRepository\Tests\Support\Models;

use IBroStudio\DataRepository\Concerns\HasOwnClassAsProperty;
use IBroStudio\DataRepository\Tests\Support\Database\Factories\FakeModelWithClassPropertyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeModelWithClassProperty extends Model
{
    use HasFactory;
    use HasOwnClassAsProperty;
    use HasOwnClassAsProperty;

    protected $table = 'referables';

    protected static function newFactory(): FakeModelWithClassPropertyFactory
    {
        return FakeModelWithClassPropertyFactory::new();
    }
}
