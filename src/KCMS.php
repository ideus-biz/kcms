<?php

namespace Kcms\Core;


final class KCMS
{
	// Log message types
	const ERROR = 'ERROR';
	const DEBUG = 'DEBUG';
	const INFO  = 'INFO';
	
	// Common environment type constants for consistency and convenience
	const PRODUCTION  = 'production';
	const STAGING     = 'staging';
	const TESTING     = 'testing';
	const DEVELOPMENT = 'development';
	
	static protected ?bool
		$Caching = null;
	
	static protected ?string
		$_Environment = null;
	static protected bool
		$_ContextFilesChanged = false;
	static protected array
		$_ContextFiles = [];
		
	static private bool
		$_IsReady = false,
		$_FilesChanged = false;
	static private string
		$_BasePath = '';
	static private ?array
		$_Classes = null,
		$_Modules,
		$_Paths = [],
		$_Files,
		$_Providers = [],
		$_ClassResolvers = [];
	
	
	/**
	 * Initializes the KCMS system.
	 *
	 * [*] The method is called during the framework autoload
	 * 
	 * [!] Do not call the method manually.
	 */
	static public function Init()
	{
		if (self::$_IsReady) return;
		
		self::$_BasePath = str_replace('packages/kcms/core/src', '', __DIR__);
		
		// self::$Caching = env('APP_CACHING', self::Env() == self::PRODUCTION);
		
		spl_autoload_register(self::_AutoLoad(...), true, true);
		register_shutdown_function(self::_ShutdownHandler(...));
	}
	
	
	static public function _AutoLoad($class): bool
	{
		if (/*self::$Caching*/ true)
		{
			if (isset(self::$_Classes[$class]))
			{
				require_once self::$_BasePath.self::$_Classes[$class];
				
				return true;
			}
		}
		
		$file = self::_LoadPSR0Class($class);
		
		if ($file != '')
		{
			require_once self::$_BasePath.$file;
			
			if (/*self::$Caching*/ true)
			{
				self::$_Classes[$class] = $file;
			}
			
			return true;
		}
		
		// Class is not in the filesystem
		return false;
	}
	
	
	static public function _ShutdownHandler(): void
	{
		if (!self::$_IsReady) return;
		
		if (/*self::$Caching*/ true)
		{
			// if (is_array(self::$_Classes)) self::_Cache('KCMS::$_Classes', self::$_Classes);
			// if (self::$_FilesChanged) self::_Cache('KCMS::$_Files', self::$_Files);
			// if (self::$_ContextFilesChanged) self::_Cache('KCMS::$_ContextFiles', self::$_ContextFiles);
		}
	}
	
	
	static private function _LoadPSR0Class(string $class): string|false
	{
		if (\str_starts_with($class, 'Kcms\\'))
		{
			/*// Try find KCMS class in App namespace
			$s = preg_replace('/^Kcms\\\(.+)/', 'App\\\$1', $class);
			$path = self::_LoadPSR0Class($s);
			if ($path) return $path;
			
			// Else find class in appropriate module*/
			
			$path = self::_LoadPSR0Class('App\\'.$class);
			if ($path) return $path;
			
			$fClassNameToPath = function($class)
			{
				$paths = explode('\\', $class);
				$package = strtolower(array_shift($paths)).DIR_SLASH.strtolower(array_shift($paths));
				$file = &$paths[count($paths)-1];
				$file = str_replace('_', DIR_SLASH, $file);
				return 'packages'.DIR_SLASH.$package.DIR_SLASH.'src'.DIR_SLASH.implode(DIR_SLASH, $paths).EXT;
			};
			
			$path = $fClassNameToPath($class);
			if (is_file(self::$_BasePath.$path))
			{
				return $path;
			}
			else
			{
				for ($i = 0, $n = count(self::$_ClassResolvers); $i < $n; $i++)
				{
					$f = self::$_ClassResolvers[$i];
					$path = $f($class);
					if ($path)
					{
						if (str_contains($path, '\\')) $path = $fClassNameToPath($path);
						if (is_file(self::$_BasePath.$path))
						{
							return $path;
						}
					}
				}
			}
		}
		elseif (\str_starts_with($class, 'App\\'))
		{
			$fClassNameToPath = function($class, $ns, $dir)
			{
				if ($ns === 'App') $file = substr($class, 3);
				else $file = $class;
				$file = str_replace(['_', '\\'], DIR_SLASH, $file);
				$path = rtrim($dir, DIR_SLASH).DIR_SLASH.ltrim($file, DIR_SLASH).EXT;
				return $path;
			};
			
			foreach ((array)self::$_Paths as $k => $v)
			{
				$path = $fClassNameToPath($class, $k, $v);
				if (is_file(self::$_BasePath.$path))
				{
					return $path;
				}
				
				for ($i = 0, $n = count(self::$_ClassResolvers); $i < $n; $i++)
				{
					$f = self::$_ClassResolvers[$i];
					$path = $f($class);
					if ($path)
					{
						if (str_contains($path, '\\')) $path = $fClassNameToPath($path, $k, $v);
						if (is_file(self::$_BasePath.$path))
						{
							return $path;
						}
					}
				}
			}
		}
		
		
		return false;
	}
	
}
