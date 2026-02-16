<?php

namespace App\Jobs;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SendEmailRegisterAccountToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email;
    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where('email',$this->email)->first();
        if($user)
        {
            $emailService = new EmailService();
            $title = 'اکانت کاربری شما با موفقیت ساخته شد';
            $details = [
                'title' => $title,
                'body' => ''
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
