<?php


/**
 * KCMS Auth App config
 * 
 * Базовая конфигурация для приложения.
 * Часть директив могут быть перекрыты пространства имён конкретного приложения для тонкой настройки Auth.
 * 
 * 
 * @package     KCMS v5 Auth module
 * @category    Configuration
 * @author      Andrey Potapov
 * @copyright   2010-2023    Andrey Potapov aka ultimus <andrew@ideus.biz>
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
 * @version     5.1.2022.0222 - `reconfirmTimeout` added
 * @version     5.3.2023.0328 - Config node `app` is a new - basic config for apps 
 * @version     5.3.2023.0524 - `action.login.logging` added 
 * @version     5.3.2023.0808 - action's `isPrivate` directive is deprecated, use routes restrictions instead; routes fix
 * @version     5.3.2023.0818 - `CRUDValidation` added
 */
return array(
	/**
	 * Выключает систему аутентификации для приложения
	 * Если система аутентификации не требуется, следует указать значение TRUE.
	 * Default: FALSE
	 * Type: bool
	 */
	'isDisabled' => false,
	
	/**
	 * Указывает, доступно ли приложение не авторизированным клиентам.
	 * Значение директивы влияет на логику системы управления доступом.
	 * 
	 * Default: FALSE
	 * Type: bool
	 */
	'isPrivate' => false,
	
	/**
	 * Указывает, должна ли система контроля доступом проверять CRUD-уровень доступа к сущностям приложения.
	 *
	 * Default: FALSE
	 * Type: bool
	 */
	'CRUDValidation' => false,
	
	/**
	 * Разрешает или запрещает аутентификацию через социальные сети
	 * 
	 * Default: FALSE
	 * Type: bool
	 */
	'isSocialEnabled' => false,
	
	/**
	 * Allows/denies authentication via AJAX requests.
	 * 
	 * Bearer token is a user's login token.
	 * 
	 * See: \Entity_Auth_User::loginToken()
	 */
	'httpAuthentication' => [
		'allowBasicAuth' => false,
		'allowBearerAuth' => false,
	],
	
	/**
	 * Общие правила аутентификации
	 */
	'rule' => [
		/**
		 * Минимальная длина пароля
		 * 
		 * [*] Максимальная длина ограничивается длиной поля `password` таблицы `users`
		 * 
		 * Default: 5
		 * Type: int
		 */
		'passwordLength' => 5,
		
		/**
		 * Шаблон пароля.
		 * Регулярное выражение, описывающее допустимые символы.
		 * 
		 * Default: empty string
		 * Type: string
		 */
		'passwordPattern' => null,
		
		/**
		 * Контекст уникальности пользователей.
		 * 
		 * Default: 'application'
		 * Type: string
		 * Options: 'application' | 'profile'
		 */
		'uniqueContext' => 'application',
		
		/**
		 * Максимальное время ожидания подтверждения регистрации пользователя, в часах
		 * 
		 * TODO: for future implementation
		 * 
		 * Default: 30*24 (hours)
		 * Type: positive integer
		 */
		//'confirmTimeout' => 30*24,
		
		/**
		 * Максимальное время ожидания сброса пароля пользователем после его запроса, в часах
		 * Если не указано или отрицательное значение, то ограничение по времени не действует.
		 * 
		 * Default: 3*24 (hours)
		 * Type: positive integer
		 */
		'resetTimeout' => 3*24,
	],
	
	/**
	 * Настройки профиля
	 */
	'account' => array(
		/**
		 * Настройка общей папки пользователя
		 */
		'directory' => array(
			/**
			 * Права к персональной папке пользователя
			 */
			'permissions' => 0777,
		),
		/**
		 * Настройка персональной папки пользователя
		 */
		'privateDirectory' => array(
			/**
			 * Права к персональной папке пользователя
			 */
			'permissions' => 0775,
		),
	),
	
	/**
	 * Ветка с перечислением контроллеров аутентификации.
	 * По-умолчанию, контроллером аутентификации для приложения default является App\Frontend\Controller_Account.
	 * Если требуется, чтобы класс контроллера был иной или в случае многопрофильного режима,
	 * следует создать отдельную ветку настроек с именем контроллера.
	 */
	'controller' => [
		/**
		 * Настройки контроллера аутентификации по-умолчанию.
		 * Имя контроллера это часть имени класса в нижнем регистре без префиксов имени приложения и имени сущности,
		 * в данном случае для класса App\Frontend\Controller_Account имя будет 'account'.
		 * 
		 * Если требуется иной класс контроллера, достаточно создать соответствующую ветку с директивами, которые требуется изменить,
		 * так как система аутентификации добавляет недостающие директивы для специфичного контроллера из настроек для контроллера по-умолчанию.
		 */
		'account' => [
			/**
			 * Тип профиля пользователей, управляемый данным контроллером
			 * 
			 * В многопрофильном режиме, следует перечислить все типы профилей, которые должны управляться данным контроллером.
			 * Если контекст уникальности выбран 'profile', то рекомендуется каждый тип профиля отдать на управление отдельному контроллеру.
			 * 
			 * Тип профиля это имя класса модели профиля в нижнем регистре без префиксов имени приложения и имени сущности,
			 * то есть для некоторого специфичного класса модели профиля App\Frontend\Entity_Account_Leader, тип профиля равен 'leader'.
			 * Очевидно, что базовый профиль - это пустая строка.
			 * 
			 * Default: ''
			 * Type: string|array
			 */
			'profile' => '',
			
			/**
			 * Настройки обработчиков контроллера.
			 * 
			 * Для неавторизованного пользователя доступ ко всем обработчикам контроллера ограничен общей директивой доступа к приложению
			 * `kcms.auth.app.isPrivate`.
			 * Однако, большинство обработчиков контроллера управления учётной записью пользователя должны быть доступны для анонимного пользователя,
			 * кроме таких, которые требуют авторизованного пользователя, например, `profile`.
			 * Поэтому для правильной настройки системы первичного доступа маршрут к контроллеру управления учётной записью пользователя
			 * должен включать ограничение: "доступ разрешён, кроме" ($route->accessAllowed(true)->restrict('profile')->accessAllowed(false);)
			 * 
			 * [*] Ряд настроек можно менять во время исполнения, если нет возможности указать значения в виде константы.
			 */
			'action' => array(
				/**
				 * Настройки поведения обработчика авторизации
				 */
				'login' => array(
					/**
					 * Маршрут, ведущий к авторизации.
					 * 
					 * Type: string
					 * Default: ':account?action=login'
					 */
					'url' => ':account?action=login',
					
					/**
					 * Маршрут перехода, в случае, если запрошена авторизация уже авторизованного пользователя
					 * 
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 * 
					 * Type: string
					 * Default: ':account?action=profile'
					 */
					'redirectOnAuthenticated' => ':account?action=profile',
					
					/**
					 * Маршрут перехода, в случае успешной авторизации.
					 * Если не указать маршрут, то переход осуществится по реферальной ссылке, если она указывает на внутреннюю страницу.
					 * В противном случае будет выполнен переход по маршруту согласно директиве `redirectOnAuthenticated`.
					 * 
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 *
					 * Type: string
					 * Default: empty value
					 * Options: route name
					 */
					'redirectOnSuccess' => '',
					
					/**
					 * Имя шаблона-подложки для авторизации.
					 * 
					 * Директива позволяет указать специфичный для страницы авторизации шаблон подложки.
					 * 
					 * Type: mixed
					 * Default: TRUE
					 * Options:
					 *  - TRUE - используется шаблон подложки по-умолчанию для приложения;
					 *  - string - указывает специфичный шаблон подложки;
					 *  - empty - требует не использовать подложку; поведение зависит от режима запроса;
					 */
					'layout' => true,
					
					/**
					 * Enables or disables logging every log in action via KCMS log system
					 * 
					 * Type: bool
					 * Default: false
					 */
					'logging' => false
				),
				
					
				/**
				 * Настройки поведения обработчика авторизации через токен авторизации (см. метод Auth::loginByToken())
				 * 
				 * Type: array|FALSE
				 * Default: FALSE
				 * Options:
				 *  - array - дополнительная настройка array('paramAuthToken' => 'authtoken', 'paramRedirectOnSuccess' => 'authredir')
				 */
				'logintoken' => false,
				
				/**
				 * Настройки поведения обработчика анонимизации (выход из личного кабинета)
				 */
				'logout' => array(
					/**
					 * Маршрут, ведущий к выходу из личного кабинета
					 * 
					 * Type: string
					 * Default: ':account?action=logout'
					 */
					'url' => ':account?action=logout',
					
					/**
					 * Маршрут перехода после выхода.
					 * Если не указать маршрут, то переход осуществится по реферальной ссылке, если она указывает на внутреннюю страницу.
					 * В противном случае будет выполнен переход на главную страницу приложения
					 * 
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 * 
					 * Default: empty value
					 * Options: route name
					 */
					'redirectOnSuccess' => '',
					
					/**
					 * Указывает, очищать ли сессию приложения или только выполнить сброс авторизации
					 * 
					 * Type: bool
					 * Default: FALSE
					 */
					'destroySession' => true,
					
					/**
					 * Enables or disables logging every log in action via KCMS log system
					 *
					 * Type: bool
					 * Default: false
					 */
					'logging' => false
				),
				
				/**
				 * Настройки поведения обработчика регистрации
				 */
				'signup' => array(
					/**
					 * Маршрут, ведущий к регистрации.
					 *
					 * Type: string
					 * Default: ':account?action=signup'
					 */
					'url' => ':account?action=signup',
					
					/**
					 * Маршрут перехода, в случае, если запрошена регистрация уже авторизованного пользователя
					 *
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 *
					 * Default: ':account?action=profile'
					 */
					'redirectOnAuthenticated' => ':account?action=profile',
					
					/**
					 * Маршрут перехода, в случае успешной авторизации.
					 * Пустое значение означает возврат к странице регистрации и, в зависимости от дирекктивы `loginOnSuccess`,
					 * будет либо выполнен переход по маршруту согласно директиве `redirectOnAuthenticated`,
					 * либо отображение сообщения об успешной регистрации.
					 *
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 *
					 * Default: empty value
					 * Options: route name
					 */
					'redirectOnSuccess' => ':account?action=confirm',
					
					/**
					 * Указывает на необходимость подтверждения регистрации (например, по ссылке из письма)
					 *
					 * Default: true
					 * Type: bool
					 */
					'requireConfirmation' => true,
					
					/**
					 * Указывает на необходимость автоматической авторизации непосредственно после регистрации.
					 * Если директива включена и требуется подтверждение регистрации, то оно будет запрошено при следующей авторизации.
					 *
					 * Default: false
					 * Type: bool
					 */
					'loginOnSuccess' => false,
				),
				
				/**
				 * Настройки поведения обработчика профиля пользователя
				 */
				'profile' => array(
					/**
					 * Маршрут, ведущий к профилю пользователя
					 *
					 * Type: string
					 * Default: ':account?action=profile'
					 */
					'url' => ':account?action=profile',
					
					/**
					 * Маршрут перехода, в случае успешного обновления профиля.
					 * Пустое значение означает возврат на страницу профиля.
					 *
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 *
					 * Default: empty value
					 * Options: route name
					 */
					'redirectOnSuccess' => '',
					
					/**
					 * Указывает, что данный обработчик требует авторизированного доступа
					 *
					 * Type: bool
					 * Deprecated
					 */
					//'isPrivate' => true
				),
				
				
				/**
				 * Настройки поведения обработчика запроса на восстановление пароля
				 */
				'forgotten' => array(
					/**
					 * Маршрут, ведущий к авторизации.
					 * 
					 * Type: string
					 * Default: ':account?action=forgotten'
					 */
					'url' => ':account?action=forgotten',
					
					/**
					 * Маршрут перехода, в случае, если запрошено восстановление пароля уже авторизованного пользователя.
					 * Следует выйти из личного кабинета для процедуры восстановления пароля.
					 * 
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 * 
					 * Default: ':account?action=profile'
					 */
					'redirectOnAuthenticated' => ':account?action=profile',
					
					/**
					 * Маршрут перехода, в случае успешного выполнения запроса на восстановление пароля.
					 * Пустое значение означает возврат к странице восстановление пароля (для сообщения результата и дальнейших действий)
					 * 
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 * 
					 * Default: empty value
					 * Options: route name
					 */
					'redirectOnSuccess' => '',
					
					/**
					 * Имя шаблона-подложки для страницы восстановления пароля.
					 * Директива позволяет указать специфичный для страницы восстановления пароля шаблон подложки.
					 *
					 * Type: mixed
					 * Default: TRUE
					 * Options:
					 *  - TRUE - используется шаблон подложки по-умолчанию для приложения;
					 *  - string - указывает специфичный шаблон подложки;
					 *  - empty - требует не использовать подложку; поведение зависит от режима запроса;
					 */
					'layout' => true,
				),
				
				/**
				 * Настройки поведения обработчика сброса пароля
				 */
				'reset' => array(
					/**
					 * Маршрут, ведущий к сбросу пароля
					 * 
					 * Type: string
					 * Default: ':account?action=reset'
					 */
					'url' => ':account?action=reset',
					
					/**
					 * Маршрут перехода, в случае, если запрошен сброс пароля уже авторизованного пользователя
					 * 
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 * 
					 * Default: ':account?action=profile'
					 */
					'redirectOnAuthenticated' => ':account?action=profile',
					
					/**
					 * Маршрут перехода, в случае успешного сброса пароля.
					 * Пустое значение означает возврат к странице сброса пароля (для сообщения результата и дальнейших действий).
					 * 
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 * 
					 * Default: empty value
					 * Options: route name
					 */
					'redirectOnSuccess' => '',
					
					/**
					 * Указывает, следует ли проинформировать пользователя об успешном результате смены пароля
					 * 
					 * Default: TRUE
					 * Type: bool
					 */
					'sendEmail' => true,
					
					/**
					 * Имя шаблона-подложки для страницы сброса пароля.
					 * Директива позволяет указать специфичный для страницы сброса пароля шаблон подложки.
					 *
					 * Type: mixed
					 * Default: TRUE
					 * Options:
					 *  - TRUE - используется шаблон подложки по-умолчанию для приложения;
					 *  - string - указывает специфичный шаблон подложки;
					 *  - empty - требует не использовать подложку; поведение зависит от режима запроса;
					 */
					'layout' => true,
				),
				
				/**
				 * Настройки поведения обработчика подтверждения регистрации
				 */
				'confirm' => array(
					/**
					 * Время, через которое допускается отправка повторного подтверждения ркегрегистрации
					 *
					 * Type: int, seconds
					 * Default: 15
					 */
					'reconfirmTimeout' => 15,
					
					/**
					 * Маршрут, ведущий к подтверждению регистрации
					 *
					 * Type: string
					 * Default: ':account?action=confirm'
					 */
					'url' => ':account?action=confirm',
					
					/**
					 * Маршрут перехода, в случае, если запрошено подтверждение регистрации уже авторизованного пользователя
					 *
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 *
					 * Default: ':account?action=profile'
					 */
					'redirectOnAuthenticated' => ':account?action=profile',
					
					/**
					 * Маршрут перехода, в случае успешного подтверждения регистрации.
					 * Пустое значение означает возврат к странице подтверждения регистрации, однако, если включена директива `loginOnSuccess`,
					 * будет выполнен переход по маршруту согласно директиве `redirectOnAuthenticated`
					 *
					 * Type: string
					 * Default: empty value
					 * Options: route name
					 */
					'redirectOnSuccess' => '',
					
					/**
					 * Указывает на необходимость автоматической авторизации непосредственно после подтверждения регистрации.
					 * После автоматической авторизации, поведение описыватеся директивой `redirectOnSuccess`.
					 *
					 * Default: false
					 * Type: bool
					 */
					'loginOnSuccess' => false,
					
					/**
					 * Имя шаблона-подложки для страницы подтверждения регистрации.
					 * Директива позволяет указать специфичный для страницы подтверждения регистрации шаблон подложки.
					 *
					 * Type: mixed
					 * Default: TRUE
					 * Options:
					 *  - TRUE - используется шаблон подложки по-умолчанию для приложения;
					 *  - string - указывает специфичный шаблон подложки;
					 *  - empty - требует не использовать подложку; поведение зависит от режима запроса;
					 */
					'layout' => true,
				),
				
				/**
				 * Настройки поведения обработчика авторизации через социальные сети
				 */
				'social_login' => array(
					/**
					 * Маршрут, ведущий к авторизации.
					 *
					 * Type: string
					 * Default: ':account?action=social_login'
					 */
					'url' => ':account?action=social_login',
					
					/**
					 * Маршрут перехода, в случае, если запрошена авторизация уже авторизованного пользователя
					 *
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 *
					 * Default: ':account?action=profile'
					 */
					'redirectOnAuthenticated' => ':',
					
					/**
					 * Маршрут перехода, в случае успешной авторизации.
					 * Пустое значение не выполнит переход.
					 *
					 * В многопрофильном режиме, если они управляются одним контроллером, можно указать URL перехода для каждого типа профиля,
					 * управляемыми данным контроллером:
					 * array(profileType => URL, ...)
					 *
					 * Default: empty value
					 * Options: route name
					 */
					'redirectOnSuccess' => ':',
				),
				
				
				/**
				 * Настройки поведения обработчика доступа к защищённым файлам пользователя приложения.
				 * Персональная папка пользователя приложения всегда располагается по пути:
				 * ./files/[APP]/account/[ACC_PROFILE][ACC_ID]/
				 * 
				 * Чтобы отключить функционал защищённого доступа в приложении, следует присвоить директиве значение FALSE.
				 * В этом случае вместо HTTP ошибки 406 (по-умолчанию для других обработчиков), будет отдаваться запрашиваемый файл.
				 */
				'file' => false,
				
				/**
				 * Настройки возможности авторизоваться с учётной записью данного приложения
				 * из-под приложения Административной Панели.
				 * 
				 * Для включения функционала, следует директиве указать значение пустого массива.
				 * Для отключения функционала - FALSE
				 */
				'loginas' => false,
			),
		],
	],
);