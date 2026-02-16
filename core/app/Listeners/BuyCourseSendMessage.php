<?php

namespace App\Listeners;

use App\Jobs\SendEmailBuyCourseToUsers;
use App\Jobs\SendSmsBuyCourseToUsers;
use App\Models\Setting\NotificationSetting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BuyCourseSendMessage
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
        $notificationSetting = NotificationSetting::where('name','buy_course')->first();
        if($notificationSetting->status == 1 | $notificationSetting->status == 3)
        {
           // SendEmailBuyCourseToUsers::dispatch($event->user,$event->course); //todo deactivate jobs
        }
        if($notificationSetting->status == 2 | $notificationSetting->status == 3)
        {
           // SendSmsBuyCourseToUsers::dispatch($event->user,$event->course); //todo deactivate jobs
        }
    }
}
