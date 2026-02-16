<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kavenegar\KavenegarApi;

class SendRejectStudentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $phoneNumber,public $supporterName,public $studentName)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $kavenagar = new KavenegarApi(\config('kavenegar.apikey'));
        $kavenagar->VerifyLookup($this->phoneNumber, $this->supporterName, $this->studentName, '', 'rejectStudent');

    }
}
