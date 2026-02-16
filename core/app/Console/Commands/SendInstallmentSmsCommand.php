<?php

namespace App\Console\Commands;

use App\Jobs\SendSmsInstallmentsToUsers;
use Illuminate\Console\Command;
use App\Models\Market\Installment;
use Carbon\Carbon;

class SendInstallmentSmsCommand extends Command
{
    protected $signature = 'installment:sms-reminder {--days=days} {--type=type}';
    protected $description = 'Send settlement sms to users';


    public function handle()
    {
        $typeLookup = [
            'reminder' => 'addDays',
            'deferred' => 'subDays'
        ];

        $days = $this->option("days");
        $type = $this->option("type");


        $installments = Installment::whereDate('installment_date', Carbon::today()->{$typeLookup[$type]}($days))
        ->whereNull('installment_passed_at')
        ->with('user')
        ->get();

        //$installments= Installment::where('user_id',124)->get();
        foreach($installments as $installment){
            SendSmsInstallmentsToUsers::dispatch($installment,$days,$type);

        }
    }
}