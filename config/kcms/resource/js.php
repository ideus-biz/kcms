<?php

/**
 * KCMS Resource JS directives
 *
 * Конфигурация компилируемых ресурсов типа JS.
 *
 * Для получения URL к ресурсу данного типа следует использовать метод
 * Resource_JS::Url(URN.js [, APPLICATION = current])
 *
 * URN - путь к ресурсу может быть организован двумя путями:
 *
 * 1. Путь к директиве данного конфигурационного файла, в которой указан(ы) файл(ы) для вывода и дополнительные настройки к ним.
 *    Например: Resource_JS::Url('config.js') - предполагает, что информация о файлах расположена в директиве:
 *     - kcms/resource/js.APPLICATION.URN.files
 *    Если URN содержит в себе символы "/" и ".", то они будут заменены на символ "_" при поиске директивы в конфигурации.
 *    Путь к файлу указывается относительно папки views/kcms/resource/js с расширением или без расширения (по-умолчанию считается .php).
 *    Файлы с расширением .php рендерятся, иначе контент отдаётся как есть.
 *
 * 2. Путь к файлу в пространстве имён шаблонов указанного приложения.
 *    Например: Resource_JS::Url('config.js') - предполагает, что файл расположен в папке `views` по пути:
 *     - APPLICATION/resource/js/URN.php
 *     - kcms/resource/js/URN.php
 */

/**
 * KCMS JS-ресурс общей настройки системы
 */
return array(
	/**
	 * Секция приложения, например, 'frontend' или 'backend'.
	 * Настройки секции 'kcms' являются базовыми для любого из приложения.
	 *
	 * Директивами данной ветки являются имена профилей с настройками.
	 * В свою очередь имя профиля представляет собой виртуальный путь к компилируемому ресурсу.
	 * Таким образом, имя компилируемого ресурса 'active/module.js' соответствует профилю 'active_module_js'.
	 * То есть символы "." и "/" заменяются в имени профиля на "_", при этом заключительная часть указывает на тип ресурса, в данном случае на 'text/javascript'.
	 *
	 * Type: array
	 */
	'kcms' => [
		'config_js' => [
			/**
			 * Allows or denies resource caching explicitly if global cache mode enabled
			 * Undefined value means to respect global mode only.
			 */
			'cache' => true,
			'minimize' => true,
			/**
			 * Порядок следования файлов должен быть указан в обратном порядке
			 */
			'files' => [
				'config',
			]
		],
		
		/**
		 * Имя профиля
		 */
		'active_module_js' => [
			/**
			 * Allows or denies resource caching explicitly if global cache mode enabled
			 * Undefined value means to respect global mode only.
			 */
			'cache' => true,
			'minimize' => true,
			/**
			 * Порядок следования файлов должен быть указан в обратном порядке
			 */
			'files' => [
				'active/ready.js',
				'active/address.js',
				'active/list.js',
				'active/popup.js',
				'active/uploader-xhr.js',
				'active/link.js',
				'active/widgets.js',
				//'active/input.js',
				'active/form.js',
				'active/zone.js',
				'active/main.js',
				'active/helpers.js',
			]
		],
		'active_module_css' => [
			'minimize' => true,
			'files' => [
				'active/module.css',
			]
		]
	],
);
