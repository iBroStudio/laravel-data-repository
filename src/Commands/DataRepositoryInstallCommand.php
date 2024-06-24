<?php

namespace IBroStudio\DataRepository\Commands;

use Illuminate\Console\Command;

class DataRepositoryInstallCommand extends Command
{
    public $signature = 'data-repository:install';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('Installing Data Repository package...');

        $this->callSilently('vendor:publish', [
            '--tag' => 'data-repository-migrations',
        ]);

        $this->call('migrate');

        $this->info('Data Repository installed');

        return self::SUCCESS;
    }
}
