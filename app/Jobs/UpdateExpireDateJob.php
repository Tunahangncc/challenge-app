<?php

namespace App\Jobs;

use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UpdateExpireDateJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $failMail;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->queue = 'update-expire-date';
        $this->failMail = config('queue.failed.fail_alert_mail');
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
                        /*** @var Purchase $purchase */

                        $purchase->update([
                            'cancelled' => true,
                        ]);
                    }
                });
        } catch (\Exception $exception) {
            logger()->error('UPDATE EXPIRE DATE JOB FAILED => '.$exception->getMessage());

            if ($this->failMail) {
                Mail::send('welcome', ['test' => 'TEST'], function ($message) {
                    $message->to($this->failMail)->subject('TEST TEST');
                });
            }
        }
    }
}
