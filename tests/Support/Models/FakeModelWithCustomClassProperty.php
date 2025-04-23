<?php

namespace IBroStudio\DataRepository\Tests\Support\Models;

use IBroStudio\DataRepository\Concerns\HasOwnClassAsProperty;
use IBroStudio\DataRepository\Tests\Support\Database\Factories\FakeModelWithCustomClassPropertyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakeModelWithCustomClassProperty extends Model
{
    use HasFactory;
    use HasOwnClassAsProperty;
    use HasOwnClassAsProperty;

    protected $table = 'referables';

    public static string $classPropertyName = 'type';

    protected static function newFactory(): FakeModelWithCustomClassPropertyFactory
    {
        return FakeModelWithCustomClassPropertyFactory::new();
    }
}
