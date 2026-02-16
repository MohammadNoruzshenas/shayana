<?php

namespace App\Jobs;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Models\Market\Settlement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SendEmailSettlementsToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $settlement;
    /**
     * Create a new job instance.
     */
    public function __construct(Settlement $settlement)
    {
        $this->settlement = $settlement;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->settlement->user->email) {
            $emailService = new EmailService();
            $details = [
                'title' => 'تسویه حساب انجام شد',
                'body' => priceFormat($this->settlement->amount) . 'مبلغ : </br>' . 'به کارت' . $this->settlement->to['cart'] . '<br>' .
                    'به نام' . $this->settlement->to['name']
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com',  Cache::get('templateSetting')->title);
            $emailService->setSubject('تسویه حساب انجام شد');
            $emailService->setTo($this->settlement->user->email);
            $messagesService = new MessageService($emailService);
            $messagesService->send();
        }
    }
}
