<?php


/**
 * KCMS eMail Configuration
 * 
 * 
 * @package    KCMS v5 module
 * @category   KCMS eMail
 * @author     Andrey Potapov
 * @copyright  2010-2022    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license    LGPL
 * @since      XII.2015
 * @version    3.2.2015.1207
 * @version    3.2.2018.0716 - 'hello' from config is added
 * @version    5.0.2021.1110 - `ssl` context configuration is added
 */
return [
	/**
	 * Имя профиля по-умолчанию
	 * Имена профилей должны содержать только буквенно-цифровые символы и символы "-", "_".
	 */
	'profile' => 'phpmailer',
	
	/**
	 * Список имён конфигурационных профилей
	 */
	'profiles' => [
		'default' => [
			/**
			 * Базовое имя класса-отправщика писем eMail_Sender_Mail.
			 * 
			 * Простой отправщик писем, использующий системнаую функцию mail() в самом простом варианте.
			 */
			'sender' => 'Mail',
			'config' => [],
		],
		
		/**
		 * Профиль, демонстрирующий настройку отправки почты сторонним ПО PHPMailer
		 * через KCMS класс-обёртку eMail_Sender_PHPMailer.
		 * 
		 * PHPMailer скрипты должны располагаться в папке: ./packages/PHPMailer
		 * 
		 * PHPMailer позволяет отправлять письма тремя методами: через системную функцию mail(), sendmail() и непосредственно SMTP протокол.
		 * Выбор метода осуществляется указанием директивы `mailer` непосредственно в ветке `config` профиля,
		 * в связи с чем следует создавать отдельный профиль под каждый из методов отправки средствами PHPMailer,
		 * в то время как данный профиль лишь демонстрирует все возвожные конфигурационные директивы.
		 */
		'phpmailer' => [
			/**
			 * Базовое имя класса-отправщика писем eMail_Sender_PHPMailer
			 * 
			 * Класс использует стороннее ПО PHPMailer, которое предоставляет расширенные возможности доставки почты
			 * 
			 * @see See PHPMailer source for details
			 */
			'sender' => 'PhpMailer',
			
			'address' => [
				'from' => 'info@localhost',
				'to' => 'info@localhost',
			],
			
			'config' => [
				/**
				 * Режим отладки
				 * Type: int
				 * Options:
				 *  `0` No output
				 *  `1` Commands
				 *  `2` Data and commands
				 *  `3` As 2 plus connection status
				 *  `4` Low-level data output
				 * @see SMTP::SMTP::DEBUG_* const
				 */
				'debug' => 0,
				/**
				 * Метод оправки почты
				 * Options: 'mail', 'sendmail', 'smtp'
				 * Default: 'mail'
				 */
				'mailer' => 'smtp',
				
				/**
				 * Конфигурация для метода mail
				 */
				'mail' => [],
				/**
				 * Конфигурация для метода sendmail
				 */
				'sendmail' => [
					'path' => null,
				],
				/**
				 * Конфигурация для метода smtp
				 */
				'smtp' => [
					'host' => 'smtp.mailgun.org',
					/**
					 * Порт SMTP сервера
					 * 25, 465 or 587
					 * Options: 25, 465 or 587
					 * Default: 25
					 */
					'port' => 587,
					/**
					 * Настройки аутентификации SMTP.
					 * Если не требуется - username должно быть пустым значением.
					 */
					'auth' => [
						'username' => 'info@localhost',
						'password' => '***',
						/**
						 * Authentication type
						 * Options: 'LOGIN' (default if empty), 'PLAIN', 'NTLM', 'CRAM-MD5'
						 * Default: empty
						 */
						'type' => '',
						'NTLM' => [
							'workstation' => '',
						],
					],
					/**
					 * Используемый метод шифрования передачи данных
					 * Options: 'ssl', 'tls'
					 * Default: empty
					 */
					'security' => 'tls',
					/**
					 * SSL options for SSL/TLS security.
					 * For example, to disable SSL certificate verification, use:
					 * [ 'verify_peer' => false, 'allow_self_signed' => false, 'verify_peer_name' => false ]
					 * or
					 * ['verify_peer' => true, 'cafile' => 'cacert.pem', 'verify_depth'  => 5, 'CN_match' => 'secure.example.com']
					 * See: https://www.php.net/manual/en/context.ssl.php
					 */
					'ssl' => [
						'verify_peer' => false,
						'allow_self_signed' => false,
						'verify_peer_name' => false
					],
					'timeout' => 100,
					
					/**
					 * Имя домена для команды HELO/EHLO
					 * 
					 * [*] Используется в случае, если доменное имя не соответствует стандарту RFC2821 4.1.1.1, определённое мейлером самостоятельно. 
					 */
					'hello' => null,
				]
			]
		],
	],
];
