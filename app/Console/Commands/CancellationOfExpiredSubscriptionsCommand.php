<?php

namespace App\Console\Commands;

use App\Jobs\CancelExpiredSubscriptionJob;
use Illuminate\Console\Command;

class CancellationOfExpiredSubscriptionsCommand extends Command
{
    protected $signature = 'app:cancellation-of-expired-subscriptions';

    protected $description = 'Cancel expired subscriptions';

    public function handle(): void
    {
        CancelExpiredSubscriptionJob::dispatch();
    }
}
