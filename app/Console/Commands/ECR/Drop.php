<?php

namespace App\Console\Commands\ECR;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kcms\Core\FS_File;
use Kcms\Ecr\Entity;
use Kcms\Ecr\Scheme;
use Symfony\Component\Console\Input\InputOption;


/**
 * Class ECRDrop
 *
 * @package    App\Console\Commands *
 * @author     Andrew Potapov <andrew@ideus.biz>
 * @copyright  2010-2023  Andrew Potapov <andrew@ideus.biz> aka ultimus
 * @since      III.20
 * @version    5.3.2023.0323
 * @version    5.3.2023.0524
 * @version    5.3.2023.1211 - clear argument has added
 */
class Drop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecr:drop {entity?} {clear?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drops ECR entity source';
	
	
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
		
        $this->addOption('entity', 'entity', InputOption::VALUE_OPTIONAL, 'Entity class name');
        // $this->addOption('clear', 'clear', InputOption::VALUE_OPTIONAL, 'Clears source, not drops');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$name = $this->argument('entity') ?? $this->option('entity');
    	$clear = $this->argument('clear');
		
		$this->_dbConn = DB::connection('mysqlRoot');
	
		if ($name == '')
		{
			$this->error("Entity class name is required");
			return;
		}
		$s = $name;
		$name = Scheme::EntityFQN($name);
		if ($name == '')
		{
			$this->error("Given class '$s' cannot be resolved.");
			return;
		}
		
		if (class_exists($name))
		{
			try
			{
				ob_start();
				$entity = new $name;
			}
			catch (\PDOException $E)
			{
				$res = null;
				if (preg_match("/Table '\w+\.(\w+)' doesn't exis/i", $E->getMessage(), $res))
				{
					ob_end_clean();
					
					$this->info("Source table does not exist");
					exit;
				}
				else throw $E;
			}
			
			//
			if ($entity instanceof Entity)
			{
				$tableName = $entity->scheme()->source()->table()->name();
				
				if (isset($clear)) $this->_mysqlTrunc($tableName);
				else $this->_mysqlDrop($tableName);
			}
			else $this->error("Object '$name' must be instance of \Kcms\ECR\Entity");
		}
		else $this->error("Class '$name' does not exist");
    }
	
	
	private function _mysqlDrop(string $table)
	{
		$query = "DROP TABLE `{$table}`;";
		$this->_dbConn->statement($query);
		$this->_logSql($table, $query);
	}
	
	
	private function _mysqlTrunc(string $table)
	{
		$query = "TRUNCATE TABLE `{$table}`;";
		$this->_dbConn->statement($query);
		$this->_logSql($table, $query);
	}
	
	
	private function _logSql(string $table, string $query)
	{
		$path = FS_File::Instance(database_path(), DOCROOT)->makeDir('ECRSync', 0775);
		FS_File::Instance($path.'/'.$table.'.sql', DOCROOT)->content($query.PHP_EOL, true);
		
		$this->info($query);
	}
	
}
