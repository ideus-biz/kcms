<?php

/**
 * KCMS Locale Configuration
 * 
 * @package     KCMS v5
 * @category    Locale
 * @author      Andrey Potapov
 * @copyright   2010-2022    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license     LGPL
 * @since       VII.2013
 * @version     3.2.2013.1017.beta
 * @version     3.2.2014.0808
 * @version     3.2.2014.1103
 */

return array(
	/**
	 * Enumerates the list of available languages for an application
	 * Type: array of ISO 639-1 standard language codes
	 */
	'I18n' => array(
		'en'
	),
	
	'da' => [
		'DK' => [
			'language' => 'Danish',
			'region' => 'Denmark',
			
			'formats' => [
				'date' => 'd.m.Y',
				'dateLong' => 'F, d Y',
				'time' => 'H:i',
				'timeLong' => 'H:i:s',
				'datetime' => 'd.m.Y H:i',
				'datetimeLong' => 'F, d Y, H:i',
				'dayname-month' => 'D, M d',
				'dayname-month-time' => 'D, M d, H:i',
			],
		]
	],
	
	/**
	 * Список доступных локализаций.
	 *
	 * Должен быть представлен в виде двумерного ассоциативного массива,
	 * в котором ключи первого уровня являются языковыми двух символьными кодами стандарта ISO 639-1 (https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes).
	 * Второй уровень массива - ассоциация настроек локализации с двух символьным кодом страны по стандарту ISO 3166-1 (https://en.wikipedia.org/wiki/ISO_3166-1).
	 * Таким образом, для одного языка может быть несколько региональных (связанных с определённой страной) настроек (локализаций).
	 * 
	 * Type: assoc array
	 * Value: array of country localization config
	 */
	'en' => array(
		'EU' => [
			'language' => 'English',
			'region' => 'Europa',
			
			'formats' => [
				'date' => 'd.m.Y',
				'dateLong' => 'F, d Y',
				'time' => 'H:i',
				'timeLong' => 'H:i:s',
				'datetime' => 'd.m.Y H:i',
				'datetimeLong' => 'F, d Y, H:i',
				'dayname-month' => 'D, M d',
				'dayname-month-time' => 'D, M d, H:i',
			],
		],
		
		'US' => array(
			'language' => 'English',
			'region' => 'USA',
			/**
			 * An alternative locale name(s) which explicitly corresponds to system locale name(s).
			 * Type: string or array of strings, empty to turn off
			 */
			'alias' => '',
			/**
			 * Charset to use within the locale.
			 * If this locale is used by global KCMS Locale it'll replace system charset (see Kohana::$charset).
			 * [!] This directive is ignored if `alias` is used.
			 * Type: string, empty to use system default
			 */
			'charset' => '',
			/**
			 * The formats of the locale
			 * Type: array of format names and format categories
			 */
			'formats' => array(
				'date' => 'm/d/Y',
				'datetime' => 'm/d/Y, g:i a',
				/**
				 * Код валюты ISO-4217 по-умолчанию.
				 * Код валюты - трехбуквенное символьное значение.
				 */
				'currency' => 'USD',
				/**
				 * Символ валюты.
				 */
				'currencyChar' => '$',
				/**
				 * Имя валюты.
				 */
				'currencyName' => 'US Dollar',
				/**
				 * Краткий формат вывода денежного значения и символа валюты.
				 * %s - символ валюты
				 * %d - значение
				 * Например, $500
				 */
				'currencyFormat' => '%s%d',
				/**
				 * Полный формат вывода денежного значения и имени валюты.
				 * %s - код валюты
				 * %d - значение
				 * Например, 500 USD
				 */
				'currencyFormatLong' => '%d %s',
				/**
				 * Формат денежного значения.
				 * Массив: [Символов после запятой, Разделитель дробной части, Разделитель тысячных значений]
				 */
				'moneyFormat' => [2, '.', ','], // see number_format()
			),
		),
	),
	
	// Russian language
	/*'ru' => [
		// Russia localization
		'RU' => [
			'language' => 'Русский',
			'region' => 'Россия',
		],
		// Ukraine localization
		'UA' => [
			'language' => 'Русский',
			'region' => 'Украина',
			
		],
	],*/
	
	/*'uk' => [
		// Ukraine localization
		'UA' => [
			'language' => 'Українська',
			'region' => 'Україна',
		]
	],*/
	
	
	/**
	 * Default formats
	 * 
	 * They can be overwritten in the specific locale
	 */
	'formats' => [
		'date' => [\IntlDateFormatter::SHORT, \IntlDateFormatter::NONE],
		'dateLong' => [\IntlDateFormatter::LONG, \IntlDateFormatter::NONE],
		'time' => [\IntlDateFormatter::NONE, \IntlDateFormatter::SHORT],
		'timeLong' => [\IntlDateFormatter::NONE, \IntlDateFormatter::LONG],
		'datetime' => \IntlDateFormatter::SHORT,
		'datetimeLong' => \IntlDateFormatter::LONG,
	]
);
