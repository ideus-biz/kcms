<?php

return array(
	/**
	 * List of all available apps
	 */
	'app' => [
		/**
		 * App alias
		 * 
		 * Alias also is used for app's route name and resource folder names as well
		 */
		'frontend' => [
			/**
			 * App URI - prefix in the URL path
			 */
			'uri' => '',
			/**
			 * App class name and its namespace - for application classes
			 */
			'name' => 'Frontend',
		],
		
		'backend' => [
			'uri' => 'admin',
			'name' => 'Backend',
		],
	],
	
	'path' => array(
		/**
		 * Общая папка хранения всех типов загружаемых файлов для всех приложений.
		 * Путь к папке является относительным к директории проекта.
		 *
		 * [*] Не рекомендуется менять это значение.
		 *
		 * Default: 'files/'
		 */
		'files' => 'files/',
		/**
		 * Общая папка хранения всех типов ресурсов для всех приложений.
		 * Путь к папке является относительным к директории проекта.
		 *
		 * [*] Не рекомендуется менять это значение.
		 *
		 * Default: 'res/'
		 */
		'resources' => 'res/',
		/**
		 * Общая папка для временных файлов
		 * Путь к папке является относительным к директории проекта.
		 *
		 * Default: 'files/tmp/'
		 */
		'tmp' => 'files/tmp/',
		
		/**
		 * Общая папка хранения защищённых файлов для всех приложений.
		 * Путь к папке является относительным к директории storage_path().
		 *
		 * [*] Не рекомендуется менять это значение.
		 *
		 * Default: 'app/.protected/'
		 */
		'protected' => 'app/.protected/',
	),
);
