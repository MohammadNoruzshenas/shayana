<?php

namespace App\Listeners;

use App\Jobs\SendEmailNewLessionToUsers;
use App\Models\Setting\NotificationSetting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewLessionSendMessage
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
        $notificationSetting = NotificationSetting::where('name','sessions_new')->first();
        if($notificationSetting->status == 1 | $notificationSetting->status == 3)
        {
           // SendEmailNewLessionToUsers::dispatch($event->lession); //todo deactivate jobs
        }
    }
}
