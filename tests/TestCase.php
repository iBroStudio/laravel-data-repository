<?php

namespace IBroStudio\DataRepository\Tests;

use Bakame\Laravel\Pdp;
use IBroStudio\DataRepository\DataRepositoryServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mpociot\VatCalculator\VatCalculatorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'IBroStudio\\DataRepository\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    // @phpstan-ignore-next-line
    protected function getPackageProviders($app): array
    {
        return [
            DataRepositoryServiceProvider::class,
            LaravelDataServiceProvider::class,
            Pdp\ServiceProvider::class,
            VatCalculatorServiceProvider::class,
        ];
    }

    // @phpstan-ignore-next-line
    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/Support/Database/Migrations/create_referables_table.php.stub';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/create_data_repository_table.php.stub';
        $migration->up();
    }
}
