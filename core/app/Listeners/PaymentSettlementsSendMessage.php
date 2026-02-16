<?php

namespace App\Listeners;

use App\Jobs\SendEmailSettlementsToUsers;
use App\Jobs\SendSmsInstallmentsToUsers;
use App\Models\Setting\NotificationSetting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentSettlementsSendMessage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $notificationSetting = NotificationSetting::where('name','settlements')->first();
        if($notificationSetting->status == 1 | $notificationSetting->status == 3)
        {
            //SendEmailSettlementsToUsers::dispatch($event->settlement); //todo deactivate jobs
        }
        if($notificationSetting->status == 2 | $notificationSetting->status == 3)
        {
            //SendSmsSettlementsToUsers::dispatch($event->settlement); //todo deactivate jobs
        }
    }
}
