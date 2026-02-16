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

class SendEmailVerficationEmailUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email;
    public $verficationEmail;

    /**
     * Create a new job instance.
     */
    public function __construct($email,$createverficationEmail)
    {
        $this->email = $email;
        $this->verficationEmail = $createverficationEmail;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $emailService = new EmailService();
        $title = Cache::get('settings')->title .':لینک فعال سازی حساب کاربری شما ';
            $details = [
                'title' => $title,
                'body' => 'برای فعال سازی حساب کاربری روی دکمه زیر کلیک کنید',
                'link' => Cache::get('secureRecord')->site_url.'/Auth/verficationEmail/'.$this->verficationEmail,
                'valueButton' => 'کلیک کنید'

            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com',  Cache::get('templateSetting')->title);
            $emailService->setSubject($title);
            $emailService->setTo($this->email);
            $messagesService = new MessageService($emailService);
            $messagesService->send();
    }
}
