<?php

namespace IBroStudio\DataObjectsRepository\Tests;

use IBroStudio\DataObjectsRepository\DataObjectsRepositoryServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use MichaelRubel\EnhancedContainer\LecServiceProvider;
use MichaelRubel\ValueObjects\ValueObjectServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'IBroStudio\\DataObjectsRepository\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            DataObjectsRepositoryServiceProvider::class,
            LaravelDataServiceProvider::class,
            //LecServiceProvider::class,
            //ValueObjectServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/Support/Database/Migrations/create_referables_table.php.stub';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/create_data_objects_repository_table.php.stub';
        $migration->up();
    }
}
