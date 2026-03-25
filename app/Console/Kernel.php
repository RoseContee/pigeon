<?php

namespace App\Console;

use App\Console\Commands\CheckCompleteMeeting;
use App\Console\Commands\CheckNoMeeting;
use App\Console\Commands\CheckScheduleEvent;
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
        CheckNoMeeting::class,
        CheckScheduleEvent::class,
        CheckCompleteMeeting::class,
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
        $schedule->command('check:schedule-event')->everyMinute()->runInBackground();
        $schedule->command('check:complete-meeting')->hourly()->runInBackground();
        $schedule->command('check:no-meeting')->dailyAt('00:00')->runInBackground();
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
