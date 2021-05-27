<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\ItemPriceCron::class,
        Commands\SendMailCron::class,
        Commands\SendDeliveryDelayMailCron::class,
        Commands\SendNonConformityMailCron::class,
        Commands\SendExpiryAlertMailCron::class,
        Commands\SendMinimumItemQuantityMailCron::class,
        Commands\SendQuoteExpiryAlertMailCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('itemprice:cron')
                ->timezone('Asia/Kolkata')
                ->dailyAt('00:01');

        $schedule->command('sendmail:cron')
                ->timezone('Asia/Kolkata')
                ->everyMinute();
    
        $schedule->command('senddeliverydelaymail:cron')
                ->timezone('Asia/Kolkata')
                ->dailyAt('6:00');

        $schedule->command('sendnonconformitymail:cron')
                ->timezone('Asia/Kolkata')
                ->dailyAt('6:00');

        $schedule->command('sendexpiryalertmail:cron')
                ->timezone('Asia/Kolkata')
                ->dailyAt('6:00');
	
	$schedule->command('sendminimumitemquantitymail:cron')
                ->timezone('Asia/Kolkata')
                ->dailyAt('6:00');

        $schedule->command('sendquoteexpiryalertmail:cron')
                ->timezone('Asia/Kolkata')
                ->dailyAt('6:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
