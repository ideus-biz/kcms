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
 * @version     5.3.2023.0505
 * @version     5.5.2024.0709
 */
return array(
	/**
	 * Enumerates the list of available languages for an application
	 * Type: array of ISO 639-1 standard language codes
	 */
	'I18n' => array(
		'da',
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
				/**
				 * Currency code - three chars string accordingly to ISO-4217
				 * Mandatory config
				 */
				'currency' => 'DKK',
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
		'DK' => [
			'language' => 'English',
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
				/**
				 * Currency code - three chars string accordingly to ISO-4217
				 * Mandatory config
				 */
				'currency' => 'DKK',
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
				 * Currency code - three chars string accordingly to ISO-4217
				 * Mandatory config
				 */
				'currency' => 'USD',
				/**
				 * Краткий формат вывода денежного значения и символа валюты.
				 * %s - символ валюты
				 * %d - значение
				 * Например, $500
				 * Optional config. If not set then system locale format is used.
				 */
				// 'currencyFormat' => '%s%d',
				/**
				 * Полный формат вывода денежного значения и имени валюты.
				 * %s - код валюты
				 * %d - значение
				 * Например, 500 USD
				 * Optional config. If not set then system locale format is used.
				 */
				// 'currencyFormatLong' => '%d %s',
				/**
				 * Символ валюты.
				 * Optional config, used only if `currencyFormat` or `currencyFormatLong` is defined
				 */
				// 'currencyChar' => '$',
				/**
				 * Имя валюты.
				 * Optional config.
				 */
				// 'currencyName' => 'US Dollar',
				/**
				 * Формат денежного значения.
				 * Массив: [Символов после запятой, Разделитель дробной части, Разделитель тысячных значений]
				 * Optional config.
				 */
				// 'moneyFormat' => [2, '.', ','], // see number_format()
			),
		),
	),
	
	// Russian language
	'ru' => [
		// Russia localization
		'RU' => [
			'language' => 'Русский',
			'region' => 'Россия',
			
			'formats' => [
				/**
				 * Currency code - three chars string accordingly to ISO-4217
				 * Mandatory config
				 */
				'currency' => 'RUR',
			],
		],
		// Ukraine localization
		'UA' => [
			'language' => 'Русский',
			'region' => 'Украина',
			
			'formats' => [
				/**
				 * Currency code - three chars string accordingly to ISO-4217
				 * Mandatory config
				 */
				'currency' => 'UAH',
			],
		],
	],
	
	'uk' => [
		// Ukraine localization
		'UA' => [
			'language' => 'Українська',
			'region' => 'Україна',
			
			'formats' => [
				/**
				 * Currency code - three chars string accordingly to ISO-4217
				 * Mandatory config
				 */
				'currency' => 'UAH',
			],
		],
	],
	
	
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
