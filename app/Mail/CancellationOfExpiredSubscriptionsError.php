<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CancellationOfExpiredSubscriptionsError extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cancellation Of Expired Subscriptions Error',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.cancellation_of_expired_subscriptions_error',
            with: [
                'fileName' => 'expired_subscriptions.xlsx',
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
