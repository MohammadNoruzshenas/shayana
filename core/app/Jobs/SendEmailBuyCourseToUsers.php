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

class SendEmailBuyCourseToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    public $course;

    /**
     * Create a new job instance.
     */
    public function __construct($user,$course)
    {

        $this->user = $user;
        $this->course = $course;


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $user = User::whereNotNull('email')->where('id', $this->user)->first();
            if($user)
            {
                $emailService = new EmailService();

                $title = ' '.$this->course->title .'با موفقیت خریداری شد ';

                $details = [
                    'title' => $title,
                    'body' => 'با تشکر از اعتماد شما'
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
