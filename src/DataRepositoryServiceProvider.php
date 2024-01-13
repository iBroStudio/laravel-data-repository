<?php

namespace IBroStudio\DataRepository;

use IBroStudio\DataRepository\Commands\DataRepositoryCommand;
use Illuminate\Support\Facades\Config;
use MichaelRubel\ValueObjects\Collection\Complex\Email;
use MichaelRubel\ValueObjects\Collection\Complex\FullName;
use MichaelRubel\ValueObjects\Collection\Complex\TaxNumber;
use MichaelRubel\ValueObjects\ValueObject;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DataRepositoryServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-data-objects-repository')
            ->hasCommand(DataRepositoryCommand::class)
            ->hasMigration('create_data_repository_table');
    }

    public function packageRegistered()
    {
        $this->registerValueObjectMacros();

    }

    public function packageBooted()
    {
        Config::set('data', array_merge_recursive(
            require __DIR__.'/../config/spatie-data.php',
            Config::get('data') ?? []
        ));
    }

    protected function registerValueObjectMacros()
    {
        ValueObject::macro('toJson', function () {

            return match (get_class($this)) {
                Email::class => json_encode(['value' => $this->value()]),
                FullName::class => json_encode(['value' => $this->value()]),
                TaxNumber::class => json_encode(['number' => $this->value()]),
                default => json_encode($this->toArray())
            };
        });
    }
}

/*
TaxNumber::macro('toJson', function () {
            return json_encode(['number' => $this->value()]);
        });

->hasInstallCommand(function(InstallCommand $command) {
    $command
        ->publishConfigFile()
        ->publishAssets()
        ->publishMigrations()
        ->askToRunMigrations()
        ->copyAndRegisterServiceProviderInApp()
        ->askToStarRepoOnGitHub('your-vendor/your-repo-name')
            });
*/
