<?php

namespace App\Console\Commands;

use App\Jobs\UpdateExpireDateJob;
use Illuminate\Console\Command;

class UpdateExpireDateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expire-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates expired records';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        UpdateExpireDateJob::dispatch();
    }
}
