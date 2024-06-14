<?php

namespace App\Console\Commands\KCMS;

use Illuminate\Console\Command;
use Kcms\Core\FS_File;
use Kcms\Resources\Entity_Resource;


class ClearResCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears media and view templates resources cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$this->info('Media resources clearing...');
		$n1 = $n2 = 0;
		foreach (Entity_Resource::Instance()->find()->all() as $v)
		{
			// $this->info($v->targetUri);
			
			if ($v->targetUri)
			{
				$file = FS_File::Instance($v->targetUri);
				$file->delete();
				$n2++;
			}
			
			$v->delete();
			$n1++;
		}
		$this->info("Deletes: $n1 entries, $n2 files");
	
		$this->info('View templates resources clearing...');
		$n1 = 0;
		$dir = FS_File::BaseRoot(storage_path('framework/cache/kcms/views'));
		foreach ($dir->readDir(true) as $d)
		{
			if ($d->isFile() && !$dir->isLink())
			{
				$d->delete();
				$n1++;
			}
		}
		$this->info("Deletes: $n1 view template files");
		
		if (function_exists('opcache_reset'))
		{
			$this->info("Clears OPCache.");
			opcache_reset();
		}
	}
    
}
