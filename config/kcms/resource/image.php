<?php

/**
* KCMS Resource Image directives
 * 
 * Rules: match, fitOn, inscribe, underlay, mode
*/

define('RES_IMG_16', 'img_16');
define('RES_IMG_32', 'img_32');
define('RES_IMG_48', 'img_48');
define('RES_IMG_96', 'img_96');
define('RES_IMG_120', 'img_120');
define('RES_IMG_192', 'img_192');
define('RES_IMG_240', 'img_240');

/**
 * Samples
 */
return array(
	'avatar_profile' => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'match' => array(
				'width' => 56,
				'height' => 56,
			),
		)
	),
	'gallery_preview' => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'match' => array(
				'width' => 166,
				'height' => 118,
			),
		)
	),
	'gallery_preview_small' => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'match' => array(
				'width' => 100,
				'height' => 80,
			),
		)
	),
	'example_list' => array(
		'set' => array(
			'mode' => array(
				//'antialiasing' => true, // default is TRUE
				//'interlacing' => false, // default is FALSE
				//'interpolation' => false, // default is FALSE
				//'alphaBlending' => false, // default is FALSE
			),
			'fitOn' => array(
				'width' => 96,
				'height' => 96,
			)
		)
	),
	'example_preview' => array(
		'set' => array(
			'mode' => array(
				//'antialiasing' => true, // default is TRUE
				//'interlacing' => false, // default is FALSE
				//'interpolation' => false, // default is FALSE
				//'alphaBlending' => false, // default is FALSE
			),
			'fitOn' => array(
				'width' => 120,
				'height' => 0,
			),
			'underlay' => array(
				'width' => 120,
				'height' => 96,
				'background' => array(
					'color' => 'CCCCCC'
				)
			)
		)
	),
	
	/**
	 * Далее следует список правил для генерации изображений общего пользования
	 */
	RES_IMG_16 => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'fitOn' => array(
				'width' => 16,
				'height' => 0,
			),
		)
	),
	RES_IMG_32 => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'fitOn' => array(
				'width' => 32,
				'height' => 0,
			),
		)
	),
	RES_IMG_48 => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'fitOn' => array(
				'width' => 48,
				'height' => 0,
			),
		)
	),
	RES_IMG_96 => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'fitOn' => array(
				'width' => 96,
				'height' => 0,
			),
		)
	),
	RES_IMG_120 => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'fitOn' => array(
				'width' => 120,
				'height' => 0,
			),
		)
	),
	RES_IMG_192 => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'fitOn' => array(
				'width' => 192,
				'height' => 0,
			),
		)
	),
	RES_IMG_240 => array(
		'set' => array(
			'mode' => array(
				'antialiasing' => true, // default is TRUE
				'interpolation' => true, // default is FALSE
			),
			'orientate' => [],
			'fitOn' => array(
				'width' => 240,
				'height' => 0,
			),
		)
	),
);
