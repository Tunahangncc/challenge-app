<?php

namespace App\Jobs;

use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateExpireDateJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->queue = 'update-expire-date';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Purchase::query()
                ->where('expire_date', '<', now()->format('Y-m-d'))
                ->chunk(1000, function ($purchases) {
                    foreach ($purchases as $purchase) {
                        $purchase->update([
                            'cancelled' => true
                        ]);
                    }
                });
        } catch (\Exception $exception) {
            logger()->error('UPDATE EXPIRE DATE JOB FAILED => ' . $exception->getMessage());
        }
    }
}
