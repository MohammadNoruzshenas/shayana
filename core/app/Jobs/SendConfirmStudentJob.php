<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kavenegar\KavenegarApi;

class SendConfirmStudentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $phoneNumbers,public $messages)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $kavenagar = new KavenegarApi(\config('kavenegar.apikey'));
        Log::info("SendConfirmStudentJob");
        $kavenagar->sendArray(config('kavenegar.number'),$this->phoneNumbers,$this->messages);
        //$kavenagar->VerifyLookup($this->phoneNumber, $this->supporterName, $this->studentName, $this->month, 'confirmStudent');

    }
}
