<?php

namespace IBroStudio\DataRepository\Commands;

use Illuminate\Console\Command;

class DataRepositoryCommand extends Command
{
    public $signature = 'laravel-data-objects-repository';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
