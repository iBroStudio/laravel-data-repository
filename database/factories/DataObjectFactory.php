<?php

namespace IBroStudio\DataRepository\Database\Factories;

use IBroStudio\DataRepository\Models\DataObject;
use IBroStudio\DataRepository\Tests\Support\DataObjects\ReferableData;
use IBroStudio\DataRepository\Tests\Support\Models\Referable;
use IBroStudio\DataRepository\ValueObjects\Authentication\SshAuthentication;
use IBroStudio\DataRepository\ValueObjects\EncryptableText;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\IBroStudio\DataRepository\Models\DataObject>
 */
class DataObjectFactory extends Factory
{
    protected $model = DataObject::class;

    public function definition(): array
    {
        return [
            'referable_id' => Referable::factory(),
            'referable_type' => Referable::class,
            'class' => ReferableData::class,
            'values' => new ReferableData(
                name: fake()->name(),
                password: EncryptableText::from(fake()->password()),
                authentication: SshAuthentication::from(
                    username: fake()->userName(),
                    privateKey: EncryptableText::from(fake()->macAddress()),
                    passphrase: EncryptableText::from(fake()->password()),
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
