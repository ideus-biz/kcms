<?php

namespace App\Console\Commands\ECR;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kcms\Core\FS_File_Text;


/**
 * Class ECRImport
 *
 * @package    App\Console\Commands *
 * @author     Andrew Potapov <andrew@ideus.biz>
 * @copyright  2010-2023  Andrew Potapov <andrew@ideus.biz> aka ultimus
 * @since      IV.2023
 * @version    5.3.2023.0414
 * @version    5.3.2023.0524
 * @version    5.3.2023.0524
 * @version    5.3.2023.0721 - keeps processed files, by renaming them
 */
class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecr:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports SQL dump';
	
	
	private
		$_dbConn;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
		
        // $this->addOption('entity', 'entity', InputOption::VALUE_REQUIRED, 'Entity class name');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	// $name = $this->option('entity');
		
		$this->_dbConn = DB::connection('mysqlRoot');
		
		$dir = new \FilesystemIterator(database_path('ECRSync'), \FilesystemIterator::KEY_AS_PATHNAME|\FilesystemIterator::CURRENT_AS_FILEINFO|\FilesystemIterator::SKIP_DOTS);
		$i = 0;
		foreach ($dir as $vD)
		{
			if ($vD->getExtension() != 'sql') continue;
			
			$this->info('--- Import file: '.$vD->getFilename());
			
			$this->_mysqlExec('START TRANSACTION;');
			try
			{
				$file = FS_File_Text::Instance($vD->getPathname(), DOCROOT);
				$query = '';
				foreach ($file as $v)
				{
					$v = trim($v);
					if ($v != '' && ltrim($v[0]) != '#')
					{
						$query .= $v.PHP_EOL;
						if (str_ends_with($v, ';'))
						{
							$this->_mysqlExec($query);
							$query = '';
						}
					}
				}
				// $file->content(PHP_EOL.PHP_EOL.'# Imported: '.Date::Format(time()), true);
				// $file->move($file.'.done');
				
				$this->_mysqlExec('COMMIT;');
				
				$file->move($file->basename().'-'.date('YmdHis').$i.'.done');
				$i++;
			}
			catch (\Exception)
			{
				$this->warn('Due to error in file '.$file->basename().' transaction has rolled back.');
				$this->_mysqlExec('ROLLBACK;');
			}
		}
    }
	
	
	private function _mysqlExec(string $query)
	{
		try
		{
			$this->info($query);
			$this->_dbConn->statement($query);
		}
		catch (\PDOException $E)
		{
			$this->error($E->getMessage());
			throw $E;
		}
	}
	
}
