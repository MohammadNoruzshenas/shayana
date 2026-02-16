<?php

namespace App\Jobs;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SendEmailAnswerTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    public $subject;
    /**
     * Create a new job instance.
     */
    public function __construct($user,$subject)
    {
        $this->user = $user;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('id',$this->user)->first();
        if($user)
        {
            $emailService = new EmailService();

            $title = 'پاسخی به تیکت '.$this->subject .' داده شده ';

            $details = [
                'title' => $title,
                'body' => 'جهت مشاهده پاسخ به پنل کاربری خود مراجعه فرمایید'
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', Cache::get('templateSetting')->title);
            $emailService->setSubject($title);
            $emailService->setTo($user->email);
            $messagesService = new MessageService($emailService);
            $messagesService->send();
        }
    }
}
