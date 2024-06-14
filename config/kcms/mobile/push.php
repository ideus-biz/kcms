<?php

/**
 * KCMS Mobile Push notifications Configuration
 * 
 * 
 * @package    KCMS v3.2 module
 * @category   KCMS Mobile
 * @author     Andrey Potapov
 * @copyright    2010-2018    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license    LGPL
 * @since      I.2016
 * @version    3.2.2016.0111
 * @version    3.2.2016.0328
 * @version    3.2.2016.1007 - Google FCM is added
 */
return [
	/**
	 * Сопоставление типа платформы с профилем push-провайдера
	 * Данная директива используется при отправке уведомлений через метод send() класса Mobile_Push_Message
	 */
	/*'profile' => [
		'android' => 'gcm',
		'ios' => 'apns',
	],*/
	'profile' => 'fcm',
	
	/**
	 * Список имён конфигурационных профилей
	 * 
	 * Имена профилей должны содержать только буквенно-цифровые символы и символы "-", "_".
	 */
	'profiles' => [
		'fcm' => [
			/**
			 * Тип используемого сервиса для push-уведомлений.
			 * Используется KCMS класс Mobile_Push_FCM - Google Firebase Cloud Messaging сервис.
			 * Данный сервис может быть выбран по-умолчанию, так как умеет доставлять сообщения как на Google, так и на Apple устройства
			 */
			'provider' => 'FCM',
			
			/**
			 * Сервис-зависимые настройки
			 */
			'config' => [
				/**
				 * Google API токен.
				 */
				'apiToken' => '****',
				
				/**
				 * URL сервиса.
				 * Если оставить пустым, Mobile_Push_FCM самостоятельно определяет URL.
				 * 
				 * Default: NULL
				 */
				'gateway' => null,
				
				/**
				 * This parameter, when set to true, allows to test a request without actually sending a message.
				 * 
				 * Type: bool
				 * Default: false
				 */
				'testMode' => false,
			],
		],
		
		'gcm' => [
			/**
			 * Тип используемого сервиса для push-уведомлений.
			 * Используется KCMS класс Mobile_Push_GCM - Google Cloud Messaging сервис.
			 */
			'provider' => 'GCM',
			/**
			 * Сервис-зависимые настройки
			 */
			'config' => [
				/**
				 * Google API токен.
				 */
				'apiToken' => '',
				
				/**
				 * Путь к папке стороннего ПО GCMMessage, реализующий фактическое взаимодействие с GSM.
				 * Путь должен быть относительным к папке ./packages (константа PACKPATH).
				 * 
				 * Подробнее о ПО GCMMessag: https://github.com/CodeMonkeysRu/GCMMessage
				 * 
				 * Default: если не установлено, то равно значению из директивы `../provider`
				 */
				'packagePath' => 'GCMMessage/',
				
				/**
				 * URL сервиса.
				 * Если оставить пустым, ПО GCMMessage самостоятельно определяет URL.
				 * 
				 * Default: NULL
				 */
				'gateway' => null,
				
				/**
				 * Путь к файлу сертификата.
				 * 
				 * Default: NULL
				 */
				'CAPath' => null,
			],
		],
		
		'apns' => [
			/**
			 * Тип используемого сервиса для push-уведомлений.
			 * Используется KCMS класс Mobile_Push_APNS.
			 */
			'provider' => 'APNS',
			/**
			 * Сервис-зависимые настройки
			 */
			'config' => [
				/**
				 * Путь к папке стороннего ПО ApnsPHP, реализующий фактическое взаимодействие с APNS.
				 * Путь должен быть относительным к папке ./packages (константа PACKPATH).
				 * 
				 * Подробнее о ПО ApnsPHP: https://github.com/immobiliare/ApnsPHP/blob/master/sample_push_many.php
				 * 
				 * Default: same as `../provider` directive
				 */
				'packagePath' => 'ApnsPHP/',
				
				/**
				 * Путь к файлам сертификатов.
				 * Путь должен быть относительным к папке, указаной в директиве packagePath.
				 */
				'CAPath' => 'cert/ca.pem',
				'CAPathSandbox' => 'cert/ca-sandbox.pem',
				'CAPathRoot' => 'cert/ca-root.pem',
				
				/**
				 * Пароль к файлу сертификата.
				 */
				'CAPass' => '',
				
				/**
				 * Тестовый режим (sandbox mode).
				 */
				'testMode' => false,
			],
		],
	],
];
