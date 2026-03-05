<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Mailtrap\Bridge\Transport\MailtrapSdkTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class MailtrapServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Mail::extend('mailtrap', function () {
            $factory = new MailtrapSdkTransportFactory();

            $apiKey = (string) env('MAILTRAP_API_KEY');
            $inboxId = (string) env('MAILTRAP_INBOX_ID');

            return $factory->create(
                new Dsn(
                    'mailtrap+sdk',
                    'sandbox.api.mailtrap.io',
                    $apiKey,
                    null,
                    null,
                    ['inboxId' => $inboxId]
                )
            );
        });
    }
}
