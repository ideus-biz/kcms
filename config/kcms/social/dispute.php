<?php

/**
 * KCMS Social Dispute config
 * 
 * @package    KCMS v5
 * @category   KCMS Social Config
 * @author     Andrey Potapov
 * @copyright  2010-2022    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license    LGPL
 * @since      XII.2014
 * @version    3.2.2014.1215
 * @version    5.1.2022.0322
 */
return array(
	/*
	 * Applications
	 */
	'frontend' => [
		'profile' => [
			/*
			 * Any custom name of entity to be disputed, for example a user
			 */
			'account' => [
				/**
				 * A model class name is being disputed
				 */
				'ownerClass' => '',
				/**
				 * Public disputing
				 */
				'isPublic' => false,
				/**
				 * General entity description
				 */
				'title' => 'Account'
			],
		],
	],
);
