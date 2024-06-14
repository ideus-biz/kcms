<?php


/**
 * KCMS Auth config for Backend app
 * 
 * Конфигурация системы аутентификации (Auth) для приложения backend.
 * Большая часть директив наследуется из узла `kcms.auth.app` (см. описаник директив там).
 * 
 * 
 * @package     KCMS v5 Auth module
 * @category    Configuration
 * @author      Andrey Potapov
 * @copyright   2010-2023    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license     LGPL
 * @since       III.2023
 * @version     5.3.2023.0328 
 */
return array(
	/**
	 * Указывает, доступно ли приложение не авторизированным клиентам.
	 * Значение директивы влияет на логику системы управления доступом.
	 * 
	 * Default: FALSE
	 * Type: bool
	 */
	'isPrivate' => true,
	
	'controller' => [
		'account' => [
			'action' => array(
				/**
				 * Настройки поведения обработчика регистрации
				 */
				'signup' => false,
				
				/**
				 * Настройки поведения обработчика профиля пользователя
				 */
				'profile' => false,
				
				/**
				 * Настройки поведения обработчика подтверждения регистрации
				 */
				'confirm' => false,
				
				/**
				 * Настройки поведения обработчика авторизации через социальные сети
				 */
				'social_login' => false,
			),
		],
	],
);
