<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // $schedule->command('inspire')->hourly();
        // $schedule->command('queue:restart')->cron('0 */12 * * *');
        //  $schedule->command('queue:work --daemon')->withoutOverlapping(12 * 60);
        Log::info("in kernel");
        $schedule->command('installment:sms-reminder --type=reminder --days=3')->dailyAt('09:00');
        $schedule->command('installment:sms-reminder --type=reminder --days=0')->dailyAt('09:20');
        $schedule->command('installment:sms-reminder --type=deferred --days=3')->dailyAt('09:30');

        $schedule->command('queue:work --daemon')->withoutOverlapping();

        // $schedule->command('queue:restart')->everyThirtyMinutes();
        // $schedule->command('queue:work')->withoutOverLapping(30);


    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
