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
	
	static protected
		$_Environment = null,
		$_ContextFiles = [],
		$_ContextFilesChanged = false;
		
	static private
		$_IsReady,
		$_BasePath,
		$_Classes,
		$_Modules,
		$_Providers = [],
		$_Paths,
		$_Files,
		$_FilesChanged = false,
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
	}
}
