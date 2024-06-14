<?php

namespace App\Console;


use App\Console\Commands\KCMS\eMailQueueDispatch;
use App\Console\Commands\KCMS\SMSQueueDispatch;
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
		eMailQueueDispatch::class,
		SMSQueueDispatch::class,
	];
	
	
	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		/**
		 * Crontab record:
		 * #* * * * * cd /var/www/html; php artisan schedule:run >> /dev/null 2>&1
		 */
		
		$schedule->command(eMailQueueDispatch::class)->everyMinute()->withoutOverlapping(false);
		$schedule->command(SMSQueueDispatch::class)->everyMinute()->withoutOverlapping(false);
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
