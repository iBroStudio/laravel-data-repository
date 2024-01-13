<?php

namespace IBroStudio\DataRepository\Database\Factories;

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ReferableData;
use IBroStudio\DataRepository\Tests\Support\Models\Referable;
use IBroStudio\DataRepository\ValueObjects\Authentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use IBroStudio\DataRepository\ValueObjects\SshAuthentication;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataObjectFactory extends Factory
{
    protected $model = DataObject::class;

    public function definition()
    {
        return [
            'referable_id' => Referable::factory(),
            'referable_type' => Referable::class,
            'class' => ReferableData::class,
            'values' => new ReferableData(
                name: fake()->name(),
                password: EncryptableText::make(fake()->password()),
                authentication: Authentication::make(
                    SshAuthentication::make(
                        privateKey: EncryptableText::make(fake()->macAddress()),
                        passphrase: EncryptableText::make(fake()->password()),
                    )
                )
            ),
        ];
    }

    public function referable(Referable $referable): static
    {
        return $this->state(fn (array $attributes) => [
            'referable_id' => $referable->id,
        ]);
    }
}
