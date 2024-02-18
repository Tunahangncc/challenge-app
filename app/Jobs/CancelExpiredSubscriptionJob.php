<?php

namespace App\Jobs;

use App\Exports\ExpiredSubscriptionsExport;
use App\Mail\CancellationOfExpiredSubscriptionsError;
use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class CancelExpiredSubscriptionJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string $failAlertMail;

    public function __construct()
    {
        $this->queue = 'cancel-expired-subscription';
        $this->failAlertMail = config('queue.failed.fail_alert_mail');
    }

    public function handle(): void
    {
        try {
            Purchase::query()->expiredSubscriptions()->chunk(1000, function ($purchases) {
                foreach ($purchases as $purchase) {
                    /** @var Purchase $purchase */
                    $purchase->update([
                        'cancelled' => true,
                    ]);
                }
            });

        } catch (\Exception $exception) {
            logger()->error('Cancel Expired Subscription Job Failed : '.$exception->getMessage());

            // Send mail
            if ($this->failAlertMail) {
                Excel::store(new ExpiredSubscriptionsExport(), 'exports/expired_subscriptions.xlsx');

                Mail::to($this->failAlertMail)->send(new CancellationOfExpiredSubscriptionsError());
            }
        }
    }
}
