<?php

namespace App\Console;


use Kcms\Core\Arr;
use Kcms\Core\FS_FileLog;


class Task
{
	static public function Run(string $command, array $args = null, bool $suppressOutput = true, bool $async = true): string|array|bool
	{
		$args ??= [];
		Arr::Walk($args, function(&$v, $k){
			$v = "--$k=$v";
		});
		$args = Arr::Implode($args, ' ');
		
		$cmd = 'php '.base_path('artisan').' '.$command.' '.$args.($suppressOutput ? ' > /dev/null':'').($async ? ' &' : '');
		$wd = getcwd();
		chdir(base_path());
		try
		{
			exec($cmd, $res);
		}
		finally
		{
			chdir($wd);
		}
		
		FS_FileLog::Instance('task-run')->writeln($cmd)->writeArray($res)->separate();
		
		return $res?:true;
	}
	
}
