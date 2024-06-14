<?php

 /**
 * KCMS Resource plugin configuration
 * 
 * @package    KCMS v5
 * @category   KCMS Resources Config
 * @author     Andrey Potapov
 * @copyright  2010-2022    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license    LGPL
 * @since      III.2013
 * @version    3.2.2013.0313
 * @version    3.2.2014.0331
 * @version    3.2.2015.0911 - New option is added: 'image.driver'
 * @version    3.2.2017.0424 - rename `CDNs` as `external`
 * @version    5.0.2021.0805 - `path` is changed to match system cache dir
 */
return [
	/**
	 * Глобальные настройки для Image ресурсов
	 */
	'image' => [
		/**
		 * Графический драйвер.
		 * 
		 * Значение по-умолчанию: 'GD'
		 */
		'driver' => 'GD',
	],
	
	/**
	 * Глобальные настройки для JS/CSS ресурсов
	 */
	'js' => [],
	
	/**
	 * Параметры, используемые подсистемой кеширования итоговых ресурсов
	 */
	'cache' => [
		/**
		 * Относительный путь к папке кеш системы.
		 * Не рекомендуется менять.
		 * 
		 * Значение по-умолчанию: 'kcms/resources/'
		 */
		'path' => 'kcms/resources/',
		
		/**
		 * Максимальное время кеширования в браузере, в секундах, по истечении которого требуется обновить ресурс.
		 * 
		 * Значение по-умолчанию: 0 (выключено обновление кешированного ресурса)
		 */
		'expire' => 0 // seconds; 0 = cache forever
	],
	
	/**
	 * Список доменных имён/IP хостов, с которых разрешается получать исходные ресурсы.
	 * Локальный хост всегда разрешён.
	 * Пустой массив запрещает внешние источники ресурсов.
	 * 
	 * Значение по-умолчанию: '*' (без ограничений)
	 */
	'external' => [
		'*'
	]
];
