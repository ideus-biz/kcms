<?php

namespace App\Console\Commands\KCMS;

use Illuminate\Console\Command;
use Kcms\Core\FS_FileLog;
use Symfony\Component\Console\Input\InputOption;


class ClearLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears a log file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->addOption('name', 'name', InputOption::VALUE_OPTIONAL);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$name = $this->option('name')?:'laravel';
    	
		//$file = FS_File::Instance('storage/logs/laravel.log', DOCROOT);
		$file = FS_FileLog::Instance($name);
		$file->clear();
		//$file->delete();
    }
    
}
