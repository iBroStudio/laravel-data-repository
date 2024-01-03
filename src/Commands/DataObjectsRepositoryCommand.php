<?php

namespace IBroStudio\DataObjectsRepository\Commands;

use Illuminate\Console\Command;

class DataObjectsRepositoryCommand extends Command
{
    public $signature = 'laravel-data-objects-repository';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
