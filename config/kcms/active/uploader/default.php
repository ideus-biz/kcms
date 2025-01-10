<?php

/*
 * KCMS Active Uploader configuration file
 * 
 * Файл конфигурации загрузчика файлов по-умолчанию.
 * 
 * Все узлы конфигурации доступны к изменению через одноимённые методы класса {@see \Kcms\Active\UploaderConfig}.
 * 
 * @package    KCMS v5
 * @category   KCMS config
 * @author     Andrey Potapov
 * @copyright  2010-2022    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license    LGPL
 * @since      II.2016
 * @version    3.2.2016.0223
 * @version    5.3.2023.1013
 * @version    5.5.2024.1227 - maxThread renamed as fileMaxCount
 * 
 * @see \Kcms\Active\UploaderConfig
 */
return [
	/**
	 * Указывает, использовать ли мультизагрузку.
	 * Если значение равно NULL, то загрузчик сам определяет режим согласно именованию коллекции:
	 * если имя коллекции содержит символа "[]", то это означает мультизагрузку.
	 *
	 * Options: TRUE|FALSE|NULL
	 * Default: NULL
	 */
	'isMultiple' => null,
	
	/**
	 * Путь сохранения загруженных файлов по-умолчанию.
	 *
	 * [*] Путь должен указываться относительно публичной папки.
	 *
	 * [*] Если значение не указано, то будет использоваться папка приложения относительно директории, указанной в конфигурации `kcms.path.files`.
	 *
	 * Default: empty value
	 */
	'filePath' => '',
	
	/**
	 *
	 * Options: bool
	 * Default: false
	 */
	'fileOverwrite' => false,
	
	/**
	 * Класс загрузчика файлов по-умолчанию.
	 *
	 * [*] Если значение не указано, то используется {@see \Kcms\Active\Uploader_XHR} класс.
	 *
	 * Default: empty value
	 */
	'uploaderClass' => '',
	
	'rule' => [
		/**
		 * Ограничение по объёму загружаемого файла.
		 * Если указано TRUE значение, то загрузчик самостоятельно определяет максимальный объём согласно PHP настройкам
		 * `post_max_size` и `upload_max_filesize`.
		 *
		 * Options: bool|int
		 * Default: FALSE
		 */
		'fileMaxSize' => false,
		/**
		 * Максимальное количество загружаемых файлов в коллекцию загрузчика
		 * Значение 0 или {@see false} выключает ограничение.
		 *
		 * Options: int
		 * Default: 0
		 */
		'fileMaxCount' => 0,
		/**
		 * Список имён расширений разрешённых к загрузке файлов
		 *
		 * Options: array
		 * Default: []
		 */
		'fileAllowedExt' => [],
		/**
		 * Список имён расширений запрещённых к загрузке файлов
		 *
		 * Options: array
		 * Default: []
		 */
		'fileDeniedExt' => [],
	],
	/**
	 * Абсолютный путь к папке загрузки файлов для временного хранения.
	 * Рекомендуется не менять данное значение.
	 *
	 * Options: NULL|string
	 * Default: NULL
	 * See: `kcms.path.tmp` directive
	 */
	'tmpDir' => null,
	/**
	 * Имя временного файла хранения загружаемого контента.
	 * Рекомендуется не менять данное значение.
	 * Имя файла по-умолчанию: "uploader"
	 *
	 * Options: string
	 * Default: NULL
	 */
	'tmpFileName' => null,
	/**
	 * Название расширения файла хранения загружаемого контента.
	 * Рекомендуется не менять данное значение.
	 * Имя файла по-умолчанию: "tmp"
	 *
	 * Options: string
	 * Default: NULL
	 */
	'tmpFileExt' => null,
];
