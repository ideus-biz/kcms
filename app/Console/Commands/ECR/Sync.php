<?php

namespace App\Console\Commands\ECR;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Kcms\Core\Arr;
use Kcms\Core\Date;
use Kcms\Core\FS_File;
use Kcms\Core\KCMS;
use Kcms\Ecr\Database;
use Kcms\Ecr\Database_Exception_SourceNotFound;
use Kcms\Ecr\Entity;
use Kcms\Ecr\Scheme;
use Kcms\Ecr\Scheme_Relation_HasMany;
use Kcms\Ecr\SourceProperty;
use Kcms\Ecr\TypeBits;
use Kcms\Ecr\TypeDate;
use Kcms\Ecr\TypeDateTime;
use Kcms\Ecr\TypeEnum;
use Kcms\Ecr\TypeFloat;
use Kcms\Ecr\TypeInteger;
use Kcms\Ecr\TypeKey;
use Kcms\Ecr\TypeKeyPrimary;
use Kcms\Ecr\TypeString;
use Kcms\Ecr\TypeText;
use Kcms\Ecr\TypeTimestamp;
use Symfony\Component\Console\Input\InputOption;


/**
 * Class ECRSync
 *
 * Command must be called via shell command-line.
 *
 * Usage:
 * > php artisan ecr:sync --entity=ENTITY
 * or
 * > php artisan ecr:sync ENTITY
 *
 * ENTITY is a name of an entity class in order:
 * EntityName - as own entity name if there is only one class of the given name in a project;
 * App\Frontend\EntityName - full-qualified entity name;
 *
 *
 * @package    App\Console\Commands *
 * @author     Andrew Potapov <andrew@ideus.biz>
 * @copyright  2010-2023  Andrew Potapov <andrew@ideus.biz> aka ultimus
 * @since      III.20
 * @version    5.3.2023.0323
 * @version    5.3.2023.0404
 * @version    5.3.2023.0504
 * @version    5.3.2023.0515 - float added
 * @version    5.3.2023.0524
 * @version    5.3.2023.0808
 * @version    5.3.2023.1211 - support of `fulltext` index for `text` props w/o length is added
 * @version    5.5.2024.0620 - TypeBits added
 */
class Sync extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'ecr:sync {entity}';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Syncs ECR entity with DB';
	
	
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
		$this->addOption('rename', 'rename', InputOption::VALUE_OPTIONAL, 'Rename prop instead of drop/adding. Use: oldName1=newName1:oldName2=newName2:...');
	}
	
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$name = $this->argument('entity') ?? $this->option('entity');
		if ($name == '')
		{
			$this->error("Entity class name is required");
			return;
		}
		
		$cfgName = config('database.default');
		$cfg = config("database.connections.{$cfgName}Super");
		if (!empty($cfg)) $this->_dbConn = DB::connection("{$cfgName}Super");
		elseif (($s = env('DB_ADMIN_USERNAME')) != '')
		{
			$cfg = ['username' => $s, 'password' => env('DB_ADMIN_PASSWORD')] + (config("database.connections.{$cfgName}")?:[]);
			$this->_dbConn = DB::connectUsing("{$cfgName}Super", $cfg);
		}
		else $this->_dbConn = DB::connection($cfgName);
		unset($s);
		
		if ($name != 'install')
		{
			$rename = $this->option('rename')??[];
			if ($rename)
			{
				$rename = str_replace(':', "\n", $rename);
				$rename = Arr::FromKVP($rename, '=', ':');
			}
			
			$s = $name;
			if (!class_exists($name)) $name = Scheme::EntityFQN($name);
			if ($name == '')
			{
				$this->error("Given class '$s' cannot be resolved.");
				return;
			}
			$this->_importEntity($name, $rename);
		}
		else
		{
			$this->_importAll();
		}
		
		$this->info("\n----------------\n");
	}
	
	
	private function _importAll()
	{
		$apps = KCMS::Applications();
		$classes = [];
		$mods = KCMS::Modules();
		
		$readDir = function($ns, $path)use(&$classes): void
		{
			foreach (FS_File::BaseRoot($path.'Entity')->readDir(true) as $file)
			{
				if ($file->isFile())
				{
					$className = str_replace($path, '', str_replace(EXT, '', $file->relativePath()));
					$className = $ns.NS_SLASH.str_replace(DIR_SLASH, '_', $className);
					$class = new \ReflectionClass(NS_SLASH.$className);
					$parents = class_parents(NS_SLASH.$className);
					$classes[$className] ??= $class->isInstantiable();
					$classes += $parents;
				}
			}
		};
		
		foreach ($mods as $ns => $v)
		{
			if ($ns == 'App')
			{
				foreach ($apps as $app)
				{
					$s = 'app'.DIR_SLASH.$app.DIR_SLASH;
					$readDir("App\\$app", $s);
				}
			}
			else
			{
				$path = KCMS::ModulePath($ns);
				foreach ($apps as $app)
				{
					$s = $path.'App'.DIR_SLASH.$app.DIR_SLASH;
					$readDir("App\\$app", $s);
				}
				$readDir($ns, $path);
			}
		}
		
		$classes = array_keys(array_filter($classes, fn($v) => $v === true));
		foreach ($classes as $v)
		{
			$this->info('Importing: '.$v);
			$this->_importEntity(NS_SLASH.$v);
			$this->info('_________'.PHP_EOL);
		}
	}
	
	
	private function _importEntity(string $name, array $rename = []): void
	{
		try
		{
			$class = new \ReflectionClass($name);
		}
		catch (\ReflectionException)
		{
			$this->error("Class '$name' does not exist");
			return;
		}
		if ($class->isInstantiable())
		{
			$entity = null;
			do
			{
				try
				{
					// ob_start();
					$entity = new $name;
				}
				catch (Database_Exception_SourceNotFound $E)
				{
					if ($E->scheme instanceof Scheme_Relation_HasMany)
					{
						// ob_end_clean();
						if ($E->scheme->farKey() && $E->scheme->foreignKey())
						{
							$this->_mysqlCreateMediator($E->tableName, $E->scheme->foreignKey(), $E->scheme->farKey());
						}
						else
						{
							$this->warn("Relation HasMany '{$E->scheme->name()}' has to declare both foreignKey and farKey prior to mediator source.");
							return;
						}
					}
					elseif ($E->scheme instanceof Scheme)
					{
						// ob_end_clean();
						$this->_mysqlCreate($name, $E->tableName);
						$this->info("\n----------------\n");
						return;
					}
					else throw $E;
				}
			} while (!$entity);
			
			//
			if ($entity instanceof Entity)
			{
				$tableName = $entity->scheme()->source()->table()->name();
				
				$dbKeys = Database::Instance($this->_dbConn)->listIndexKeys($tableName);
				$dbSchemeKeys = $this->_dbEntityKeys($dbKeys);
				$dbProps = Database::Instance($this->_dbConn)->listColumns($tableName);
				$dbScheme = [];
				foreach ($dbProps as $k => $v)
				{
					$desc = $this->_dbEntityProp($dbProps, $k);
					isset($desc) && $dbScheme[$k] = $desc;
				}
				
				$schemeKeys = [];
				$scheme = [];
				$refClass = new \ReflectionClass($entity->scheme());
				$refProps = [];
				foreach ($refClass->getProperties(\ReflectionProperty::IS_PUBLIC) as $vProp)
				{
					$propName = $vProp->getName();
					$attrs =$vProp->getAttributes(SourceProperty::class);
					if (!empty($attrs)) $refProps[$propName] = $vProp;
				}
				
				if (empty($refProps))
				{
					$this->warn('Entity has no source property defined');
					return;
				}
				
				foreach ($refProps as $vProp)
				{
					$propName = $vProp->getName();
					
					//
					$attrs = [];
					foreach ($vProp->getAttributes() as $vAttr)
					{
						if ($vAttr->getName() == TypeKey::class) $attrs[$vAttr->getName()][] = $vAttr->getArguments();
						else $attrs[$vAttr->getName()] = $vAttr->getArguments();
					}
					
					$this->_entityKeys($schemeKeys, $propName, $attrs);
					$desc = $this->_entityProp($vProp, $attrs);
					
					isset($desc) && $scheme[$propName] = $desc;
				}
				
				if (!empty($dbScheme) && !empty($scheme))
				{
					// Modify
					$add = $change = $modify = $delete = [];
					$prev = 0;
					foreach ($scheme as $k => $v)
					{
						$s = $this->_mysqlFieldDesc($k, $scheme, $schemeKeys);
						if ($s == '') continue;
						$oldName = array_search($k, $rename);
						
						if (isset($dbScheme[$k]) || ($oldName && isset($dbScheme[$oldName])))
						{
							if ($oldName && isset($dbScheme[$k])) $oldName = false;
							$s2 = $this->_mysqlFieldDesc($oldName?:$k, $dbScheme, $dbSchemeKeys);
							if ($s2 && $s2 != $s)
							{
								if ($oldName) $change[$oldName] = $s;
								else
								{
									$modify[] = $s;
								}
							}
						}
						else
						{
							$add[$prev] = $s;
						}
						$prev = $k;
					}
					foreach ($dbScheme as $k => $v)
					{
						if (!isset($scheme[$k]) && !isset($rename[$k])) $delete[] = $k;
					}
					
					//$this->info('MODIFY : ADD : DROP');
					// x_dumpe($change, $modify, $add, $delete);
					
					$this->_logSql($tableName, PHP_EOL.'#---'.PHP_EOL.'# '.Date::Format(time(), 'Y-m-d H:i:s'));
					// $this->info(PHP_EOL);
					// $this->info('----- MODIFY ---------');
					$this->_mysqlModify($tableName, $modify);
					// $this->info(PHP_EOL);
					// $this->info('----- CHANGE ---------');
					$this->_mysqlChange($tableName, $change);
					// $this->info(PHP_EOL);
					// $this->info('----- ADD    ---------');
					$this->_mysqlAdd($tableName, $add);
					// $this->info(PHP_EOL);
					// $this->info('----- DROP   ---------');
					$this->_mysqlDrop($tableName, $delete);
					
					$this->info(PHP_EOL);
					$this->info('----- KEYS ---------');
					$dbKeys = Database::Instance($this->_dbConn)->listIndexKeys($tableName);
					$dbSchemeKeys = $this->_dbEntityKeys($dbKeys);
					$this->_mysqlSyncKeys($tableName, $schemeKeys, $dbSchemeKeys);
				}
			}
			else $this->error("Object '$name' must be successor of ".Entity::class." class");
		}
		else $this->error("Class '$name' is not instantiable");
	}
	
	
	private function _dbEntityKeys($dbKeys)
	{
		$ret = [];
		
		foreach ($dbKeys as $k => $v)
		{
			if (!empty($v['columns']))
			{
				if ($k === 'PRIMARY')
				{
					$ret['PRIMARY'] = reset($v['columns']);
				}
				else
				{
					$s = $v['isUnique'] ? 'unique':'key';
					if ($v['type'] === 'FULLTEXT') $s = 'fulltext';
					$ret[$k][$s] = $v['columns'];
				}
			}
		}
		
		return $ret;
	}
	
	
	private function _dbEntityProp(array $dbProps, string $propName)
	{
		$desc = null;
		if (isset($dbProps[$propName]))
		{
			$desc = O();
			$dbProp = $dbProps[$propName];
			if ($dbProp['type'] == 'int')
			{
				if ($dbProp['data_type'] == 'tinyint') $desc->type('TINYINT(1)');
				elseif ($dbProp['data_type'] == 'int') $desc->type('INT');
				elseif ($dbProp['data_type'] == 'int unsigned') $desc->type('INT UNSIGNED');
			}
			elseif ($dbProp['type'] == 'float')
			{
				if ($dbProp['data_type'] == 'float') $desc->type('FLOAT');
				elseif ($dbProp['data_type'] == 'float unsigned') $desc->type('FLOAT UNSIGNED');
			}
			elseif ($dbProp['type'] == 'string')
			{
				if ($dbProp['data_type'] == 'timestamp') $desc->type('TIMESTAMP');
				elseif ($dbProp['data_type'] == 'date') $desc->type('DATE');
				elseif ($dbProp['data_type'] == 'datetime') $desc->type('DATETIME');
				elseif (\str_ends_with($dbProp['data_type'], 'text')) $desc->type(strtoupper($dbProp['data_type']));
				elseif ($dbProp['data_type'] == 'varchar') $desc->type('VARCHAR('.$dbProp['character_maximum_length'].')');
				elseif ($dbProp['data_type'] == 'char') $desc->type('CHAR('.$dbProp['character_maximum_length'].')');
				elseif ($dbProp['data_type'] == 'bit') $desc->type('BIT('.$dbProp['character_maximum_length'].')');
				elseif ($dbProp['data_type'] == 'enum')
				{
					$choice = "'".Arr::Implode($dbProp['options'], "','")."'";
					$desc->type('ENUM('.$choice.')');
				}
				else
				{
					// x_dumpce($dbProp);
					$this->warn("Unhandled DB datatype for `{$propName}`: {$dbProp['data_type']}");
				}
			}
			else $this->warn("Unhandled DB column type for `{$propName}`: ".get_class($dbProp));
			
			if (isset($desc->type))
			{
				$desc->nullable($dbProp['is_nullable']);
				if ($dbProp['column_default'] !== null) $desc->default($dbProp['column_default']);
				elseif ($desc->nullable) $desc->default("\x0");
			}
		}
		
		return $desc;
	}
	
	
	private function _entityKeys(array &$keys, string $propName, array $attrs)
	{
		if (isset($attrs[TypeKeyPrimary::class]))
		{
			$keys['PRIMARY'] = $propName;
		}
		elseif (isset($attrs[TypeKey::class]))
		{
			foreach ($attrs[TypeKey::class] as $vKey)
			{
				$name = $vKey['name']??$vKey[0]??true;
				if ($name === true) $name = $propName;
				
				if (isset($attrs[TypeText::class]))
				{
					$len = null; // Key length. For future use.
					if ($len == 0) $s = 'fulltext';
				}
				else $s = ($vKey['isUnique']??$vKey[1]??false) ? 'unique':'key';
				
				$keys[$name][$s][] = $propName;
			}
		}
	}
	
	
	private function _entityProp(\ReflectionProperty $prop, array $attrs)
	{
		$desc = O();
		
		if ($prop->getType()->getName() == 'int')
		{
			if (isset($attrs[TypeBits::class]))
			{
				$len = $attrs[TypeBits::class]['length']??$attrs[TypeBits::class][0]??8;
				$desc->type('BIT('.$len.')');
			}
			elseif (!isset($attrs[TypeInteger::class]) || ($attrs[TypeInteger::class]['isUnsigned']??$attrs[TypeInteger::class][0]??false)) $desc->type('INT UNSIGNED');
			else $desc->type('INT');
		}
		elseif ($prop->getType()->getName() == 'float')
		{
			if (!isset($attrs[TypeFloat::class]) || ($attrs[TypeFloat::class]['isUnsigned']??$attrs[TypeFloat::class][0]??false)) $desc->type('FLOAT UNSIGNED');
			else $desc->type('FLOAT');
		}
		elseif ($prop->getType()->getName() == 'bool')
		{
			$desc->type('TINYINT(1)');
		}
		elseif ($prop->getType()->getName() == 'string')
		{
			if (isset($attrs[TypeString::class]))
			{
				$len = $attrs[TypeString::class]['length']??$attrs[TypeString::class][0]??255;
				$desc->type('VARCHAR('.$len.')');
			}
			elseif (isset($attrs[TypeEnum::class]))
			{
				$choice = $attrs[TypeEnum::class]['choice']??$attrs[TypeEnum::class][0]??[];
				$choice = "'".Arr::Implode($choice, "','")."'";
				$desc->type('ENUM('.$choice.')');
			}
			elseif (isset($attrs[TypeText::class]))
			{
				$choice = $attrs[TypeText::class]['dimension']??$attrs[TypeText::class][0]??[];
				$choice = in_array($choice, ['','tiny','medium','long']) ? $choice : '';
				$desc->type(strtoupper($choice).'TEXT');
			}
			elseif (isset($attrs[TypeDate::class])) $desc->type('DATE');
			elseif (isset($attrs[TypeDateTime::class])) $desc->type('DATETIME');
			elseif (isset($attrs[TypeTimestamp::class])) $desc->type('TIMESTAMP');
			else $desc->type('VARCHAR(255)');
		}
		else $this->error("Property {$prop->getName()} has invalid type. Remove #[PropertyType] attribute or fix the type to valid one.");
		
		if (isset($desc->type))
		{
			$desc->nullable($prop->getType()->allowsNull());
			
			if ($prop->hasDefaultValue() || $prop->getType()->allowsNull())
			{
				if ($prop->getDefaultValue() !== null)
				{
					if ($prop->getType()->getName() == 'int' || $prop->getType()->getName() == 'bool')
						$desc->default((int)$prop->getDefaultValue());
					elseif ($prop->getType()->getName() == 'string' && \str_ends_with($desc->type, 'TEXT'))
						// BLOB, TEXT, GEOMETRY or JSON column 'description' can't have a default value
						$desc->default("\x0");
					elseif ($prop->getType()->getName() == 'string' || $prop->getType()->getName() == 'float')
						$desc->default((string)$prop->getDefaultValue());
				}
				else $desc->default("\x0");
			}
		}
		
		return $desc;
	}
	
	
	private function _mysqlFieldDesc($propName, $scheme, $keys)
	{
		$desc = $scheme[$propName];
		if (empty($desc->type)) return '';
		
		$ret = "`{$propName}` ".$desc->type;
		if (!$desc->nullable) $ret .= ' NOT';
		$ret .= ' NULL';
		if (isset($keys['PRIMARY']) && $keys['PRIMARY'] == $propName) $ret .= '';//' AUTO_INCREMENT';
		elseif (isset($desc->default)) $ret .= ' DEFAULT '.($desc->default === "\x0" ? 'NULL' : "'{$desc->default}'");
		
		if (isset($desc->comment)) $ret .= " COMMENT '".str_replace("'", "\'", $desc->comment)."'";
		
		return $ret;
	}
	
	
	private function _mysqlModify(string $table, array $props)
	{
		if (!empty($props))
		{
			array_walk($props, function(&$v){
				$v = "MODIFY $v";
			});
			
			$query = "ALTER TABLE `{$table}`\n";
			$query .= implode(",\n", $props);
			$query .= ";";
			
			// $this->info($query);
			// $this->info("\n");
			$this->_dbConn->statement($query);
			$this->_logSql($table, $query);
		}
	}
	
	private function _mysqlChange(string $table, array $props)
	{
		if (!empty($props))
		{
			array_walk($props, function(&$v, $k){
				$v = "CHANGE `$k` $v";
			});
			
			$query = "ALTER TABLE `{$table}`\n";
			$query .= implode(",\n", $props);
			$query .= ";";
			
			// $this->info($query);
			// $this->info("\n");
			$this->_dbConn->statement($query);
			$this->_logSql($table, $query);
		}
	}
	
	private function _mysqlAdd(string $table, array $props)
	{
		if (!empty($props))
		{
			array_walk($props, function(&$v, $k){
				$v = "ADD $v";
				if ($k === 0) $v .= " FIRST";
				else $v .= " AFTER `$k`";
			});
			
			$query = "ALTER TABLE `{$table}`\n";
			$query .= implode(",\n", $props);
			$query .= ";";
			
			// $this->info($query);
			// $this->info("\n");
			$this->_dbConn->statement($query);
			$this->_logSql($table, $query);
		}
	}
	
	private function _mysqlDrop(string $table, array $props)
	{
		if (!empty($props))
		{
			array_walk($props, function(&$v){
				$v = "DROP `$v`";
			});
			
			$query = "ALTER TABLE `{$table}`\n";
			$query .= implode(",\n", $props);
			$query .= ";";
			
			// $this->info($query);
			// $this->info("\n");
			try
			{
				$this->_logSql($table, $query);
				$this->_dbConn->statement($query);
			}
			catch (\Exception $E)
			{
				$this->error($E->getMessage());
			}
		}
	}
	
	private function _mysqlSyncKeys(string $table, array $entityKeys, array $dbKeys)
	{
		if (!empty($entityKeys['PRIMARY']) && empty($dbKeys['PRIMARY']))
		{
			$query = "ALTER TABLE `$table` ADD PRIMARY KEY (`{$entityKeys['PRIMARY']}`);";
			// $this->info($query);
			$this->_dbConn->statement($query);
			$this->_logSql($table, $query);
		}
		
		//x_dump($entityKeys, $dbKeys);
		foreach ($entityKeys as $kName => $vKey)
		{
			if ($kName == 'PRIMARY') continue;
			
			$keyType = key($vKey);
			$cols = $vKey[$keyType];
			
			if (isset($dbKeys[$kName]))
			{
				$keyTypeDb = key($dbKeys[$kName]);
				$colsDb = $dbKeys[$kName][$keyTypeDb];
				if ($keyType != $keyTypeDb || count($cols) != count($colsDb) || count($cols) != count(array_intersect($cols, $colsDb)))
				{
					$query = "ALTER TABLE `$table` DROP INDEX `$kName`;";
					// $this->info($query);
					$this->_dbConn->statement($query);
					$this->_logSql($table, $query);
					unset($dbKeys[$kName]);
				}
			}
			
			if (!isset($dbKeys[$kName]))
			{
				$s = '`'.implode('`,`', $cols).'`';
				$query = "ALTER TABLE `$table` ADD {$keyType} `$kName` ($s);";
				// $this->info($query);
				$this->_dbConn->statement($query);
				$this->_logSql($table, $query);
			}
		}
		
		if (!empty($dbKeys))
		{
			foreach ($dbKeys as $kName => $vCols)
			{
				if (!isset($entityKeys[$kName]))
				{
					$query = "ALTER TABLE `$table` DROP INDEX `$kName`;";
					// $this->info($query);
					$this->_dbConn->statement($query);
					$this->_logSql($table, $query);
				}
			}
		}
	}
	
	
	private function _mysqlCreate(string $entityClass, string $table)
	{
		$schemeKeys = [];
		$scheme = [];
		$refClass = new \ReflectionClass($entityClass::SchemeClassName());
		$propMove = [];
		foreach ($refClass->getProperties(\ReflectionProperty::IS_PUBLIC) as $vProp)
		{
			$propName = $vProp->getName();
			
			//
			$attrs =$vProp->getAttributes(SourceProperty::class);
			if (!empty($attrs))
			{
				$after = $attrs[0]->getArguments()['afterProperty']??$attrs[0]->getArguments()[0]??null;
				if (isset($after)) $propMove[$propName] = $after;
				
				$attrs = [];
				foreach ($vProp->getAttributes() as $vAttr)
				{
					if ($vAttr->getName() == TypeKey::class) $attrs[$vAttr->getName()][] = $vAttr->getArguments();
					else $attrs[$vAttr->getName()] = $vAttr->getArguments();
				}
				
				$this->_entityKeys($schemeKeys, $propName, $attrs);
				$desc = $this->_entityProp($vProp, $attrs);
				isset($desc) && $scheme[$propName] = $desc;
			}
		}
		
		if (empty($scheme))
		{
			$this->warn("Entity $entityClass has no scheme defined");
			return;
		}
		
		$fields = [];
		foreach ($scheme as $k => $v)
		{
			$s = $this->_mysqlFieldDesc($k, $scheme, $schemeKeys);
			if ($s == '') continue;
			$fields[] = $s;
		}
		
		$query = "CREATE TABLE `{$table}` (\n".implode(",\n", $fields)."\n) ENGINE=InnoDB COMMENT='Source for $entityClass';";
		// $this->info($query);
		$this->_dbConn->statement($query);
		$this->_logSql($table, $query);
		
		$this->_mysqlSyncKeys($table, $schemeKeys, []);
		
		//
		foreach ($propMove as $k => $v)
		{
			$s = $this->_mysqlFieldDesc($k, $scheme, $schemeKeys);
			if ($s == '') continue;
			$query = "ALTER TABLE `{$table}` MODIFY $s";
			if ($v == '') $query .= ' FIRST';
			else $query .= " AFTER `$v`;";
			// $this->info($query);
			$this->_dbConn->statement($query);
			$this->_logSql($table, $query);
		}
		
		//
		$pk = $schemeKeys['PRIMARY']??null;
		if (isset($pk) && str_contains($scheme[$pk]->type.' U', 'INT U'))
		{
			$s = $this->_mysqlFieldDesc($schemeKeys['PRIMARY'], $scheme, $schemeKeys);
			if ($s)
			{
				$query = "ALTER TABLE `{$table}` MODIFY {$s} AUTO_INCREMENT;";
				// $this->info($query);
				$this->_dbConn->statement($query);
				$this->_logSql($table, $query);
			}
		}
	}
	
	
	private function _mysqlCreateMediator(string $table, string $fKey, string $farKey)
	{
		$fields = [
			"`$fKey` int unsigned not null",
			"`$farKey` int unsigned not null",
			"KEY `ident` (`$fKey`,`$farKey`)"
		];
		$query = "CREATE TABLE `{$table}` (\n".implode(",\n", $fields)."\n) ENGINE=InnoDB;";
		// $this->info($query);
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
