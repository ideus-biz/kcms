<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('log:clear', function() {
	
	//exec('rm -f ' . storage_path('logs/*.log'));
	//exec('rm -f ' . base_path('*.log'));
	file_put_contents(storage_path('logs/laravel.log'), '');
	
	$this->comment('Logs have been cleared!');
	
})->describe('Clear log files');
