<?php

namespace App\Jobs;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SendForgetPasswordEmailUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email;
    public $token;

    /**
     * Create a new job instance.
     */
    public function __construct($email,$token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $emailService = new EmailService();
        $title = Cache::get('templateSetting')->title .'- بازیابی رمز عبور ';
            $details = [
                'title' => $title,
                'body' => 'برای باز یابی رمز عبور روی دکمه زیر کلیک کنید',
                'link' => Cache::get('secureRecord')->site_url."/Auth/EmailResetPassword/".$this->token,
                'valueButton' => "بازیابی",
            ];
            $emailService->setDetails($details);
            $emailService->setFrom( Cache::get('secureRecord')->mail_username,  Cache::get('templateSetting')->title);
            $emailService->setSubject($title);
            $emailService->setTo($this->email);
            $messagesService = new MessageService($emailService);
            $messagesService->send();
    }
}
