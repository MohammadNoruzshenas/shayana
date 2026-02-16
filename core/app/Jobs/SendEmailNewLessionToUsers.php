<?php

namespace App\Jobs;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Models\Market\Lession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SendEmailNewLessionToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $lession;
    /**
     * Create a new job instance.
     */
    public function __construct(Lession $lession)
    {
        $this->lession = $lession;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = $this->lession->course->students->whereNotNull('email');
        foreach ($users as $user) {
            $emailService = new EmailService();
            $title = 'جلسه '. $this->lession->title .' منتشر شد ';
            $details = [
                'title' => $title,
                'body' => 'جهت مشاهده دوره به وبسایت مراجعه کنید'
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


