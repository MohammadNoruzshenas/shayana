<?php

namespace App\Jobs;

use App\Models\Market\Installment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kavenegar\KavenegarApi;

class SendSmsInstallmentsToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $installment;
    public $tries=3;

    /**
     * Create a new job instance.
     */
    public function __construct(Installment $installment,public int $days,public string $type)
    {
        $this->installment = $installment;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pattern = '';

        $token2 = '';
        $token3 = '';

        $user = $this->installment->user;
        $amount = number_format($this->installment->installment_amount);

        if ($user->mobile) {
            if ($this->type == 'reminder') {
                if ($this->days == 0) {
                    $pattern = 'ghestPass';
                    $token = $amount;
                } else {
                    $pattern = 'ghestReminder';
                    $token = $this->days;
                    $token2 = $amount;
                }
            } else {
                $pattern = 'ghestDefered';
                $token = $this->days;
                $token2 = $amount;
            }
            $kavenagar = new KavenegarApi(\config('kavenegar.apikey'));
            dump("mobile:$user->mobile token:$token token2:$token2 token3:$token3 pattern:$pattern");
            $kavenagar->VerifyLookup($user->mobile, $token, $token2, $token3, $pattern);
        }
    }
}
