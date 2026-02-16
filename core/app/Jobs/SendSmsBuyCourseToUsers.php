<?php

namespace App\Jobs;

use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class SendSmsBuyCourseToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    public $course;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $course)
    {
        $this->user = $user;
        $this->course = $course;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::whereNotNull('mobile')->where('id', $this->user)->first();
        if ($user) {
            $smsService = new SmsService();
            $smsService->setTo(['0' . $user->mobile]);
            $body =  ' ' . $this->course->title . ' با موفقیت خریداری شد  ';
            $smsService->setText($body);
            $smsService->setIsFlash(true);
            $messagesService = new MessageService($smsService);
            $messagesService->send();
        }
    }
}
