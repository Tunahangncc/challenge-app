<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AllDeviceWithOSInformationReportMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'All Device With OS Information Report Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.report_mail',
            with: [
                'fileName' => 'all_device_with_os_information_report.xlsx',
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
