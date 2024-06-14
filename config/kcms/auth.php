<?php


/**
 * KCMS Auth config
 * 
 * Базовая конфигурация системы аутентификации (Auth) для приложения default.
 * Часть директив могут быть перекрыты проектом из пространства имён приложения для тонкой настройки Auth для приложения default.
 * Иные приложения должны полностью перекрывать все директивы Auth, используя данный конфиг как пример.
 * 
 * 
 * @package     KCMS v5 Auth module
 * @category    Configuration
 * @author      Andrey Potapov
 * @copyright   2010-2022    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license     LGPL
 * @since       X.2013
 * @version     3.2.2013.1009
 * @version     3.2.2014.1002
 * @version     3.2.2015.0305
 * @version     3.2.2015.0320 - signup route is added
 * @version     3.2.2015.0922 - реогранизация структуры конфига для возможности указания специфичного управляющуго контроллера
 * @version     3.2.2015.1013 - new config directives: rule/resetTimeout and rule/confirmTimeout
 * @version     3.2.2016.0519 - `loginas` directive
 * @version     3.2.2016.0817 - `logout`.`destroySession` is added
 * @version     3.2.2016.0901 - redirect by profile type is added for directives like redirectOn*
 * @version     3.2.2016.0928 - `reset`.`sendEmail` is added
 * @version     3.2.2016.1026 - `action`.`logintoken` directive is added
 * @version     3.2.2017.0529 - routes are now may not contain app name; `layout` directive for forgotten, reset, confirm actions
 * @version     3.2.2017.0607 - `action`.`login`.`redirectOnSuccess` behavior is updated if empty
 * @version     3.2.2017.0627 - `rule`.`passwordPattern` is added
 * @version     3.2.2017.1201 - review
 * @version     3.3.2019.0103 - auth module deprecated, its config is moved in here 
 * @version     3.3.2019.0122 - `wwwMethod` is removed 
 * @version     3.3.2020.0316 - `hashMethod` is deprecated
 * @version     5.3.2023.0328 - social config has moved in separate file
 * @version     5.3.2023.0612 - `saltPattern` must be global
 */
return array(
	/**
	 * Authorization store time aka "remember me", in minutes
	 */
	'lifetime'     => 43200,
	/**
	 * The name of data in the session and auth cookie
	 */
	'sessionKey'  => 'auth_user',
	/**
	 * String with random number separated with comma.
	 * Used to generate password hash sum
	 * 
	 * [!] This is a global value. Do not overwrite it in application based config.
	 */
	'saltPattern' => '1, 3, 5, 9, 14, 15, 20, 21, 28, 30',
);
