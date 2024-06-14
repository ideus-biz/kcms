<?php


/**
 * KCMS Mobile SMS notifications Configuration
 * 
 * 
 * @package    KCMS v5 module
 * @category   KCMS Mobile
 * @author     Andrey Potapov
 * @copyright  2010-2022    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license    LGPL
 * @since      III.2016
 * @version    3.2.2016.0328
 * @version    3.2.2016.1228 - fix translit
 * @version    3.2.2018.0315 - Twilio config
 * @version    5.1.2021.1214
 */
return [
	/**
	 * Имя профиля по-умолчанию
	 */
	'profile' => 'twilio',
	
	/**
	 * Список имён конфигурационных профилей
	 * 
	 * Имена профилей должны содержать только буквенно-цифровые символы и символы "-", "_".
	 */
	'profiles' => [
		'bsg' => [
			'provider' => 'BSG',
			'config' => [
				/**
				 * API key
				 */
				'apiKey' => '',
				
				'from' => '',
				
				/**
				 * Правило имени отправителя
				 *
				 * Число максимальной длины или строка регулярного выражения
				 *
				 * Type: int|string
				 * Default: empty
				 * Required: false
				 */
				'fromRule' => 11,
			],
		],
		
		'smsc' => [
			'isDisabled' => true,
			
			/**
			 * Тип используемого сервиса для SMS-уведомлений.
			 * Используется KCMS класс Mobile_SMS_SMSC - http://smsc.ru/api
			 */
			'provider' => 'SMSC',
			/**
			 * Сервис-зависимые настройки
			 */
			'config' => [
				/**
				 * Логин Клиента
				 * 
				 * Type: string
				 * Required: true
				 */
				'login' => '',
				
				/**
				 * Пароль Клиента
				 * 
				 * Type: string
				 * Required: true
				 */
				'password' => '',
				
				/*
				 * Имя отправителя, отображаемое в телефоне получателя. Разрешены английские буквы, цифры, пробел и некоторые символы.
				 * Длина – 11 символов или 15 цифр. Все имена регистрируются в личном кабинете.
				 * Для отключения Sender ID по умолчанию необходимо в качестве имени передать пустую строку. 
				 * 
				 * Type: string
				 * Default: empty
				 * Required: false
				 */
				'from' => '',
				
				/**
				 * Правило имени отправителя
				 * 
				 * Число максимальной длины или строка регулярного выражения
				 * 
				 * Type: int|string
				 * Default: empty
				 * Required: false
				 */
				'fromRule' => '/\d{0,15}|\w{0,11}/ui',
				
				/**
				 * Признак того, что сообщение необходимо перевести в транслит.
				 *  0 (по умолчанию) – не переводить в транслит.
				 *  1 – перевести в транслит в виде "translit".
				 *  2 – перевести в транслит в виде "mpaHc/Ium".
				 * 
				 * Type: int
				 * Default: 0
				 * Required: false
				 */
				'translit' => 0,
			],
		],
		
		'twilio' => [
			'isDisabled' => true,
			
			'provider' => 'Twilio',
			/**
			 * Сервис-зависимые настройки
			 */
			'config' => [
				/*
				 * Номер исходящих сообщений. 
				 * 
				 * Type: string
				 * Default: empty
				 * Required: true
				 */
				'from' => '+1000000000',
				
				/**
				 * Twilio AccountSID
				 */
				'accountSID' => '',
				
				/**
				 * Twilio AuthToken
				 */
				'authToken' => '',
			],
		],
	
	],
];
