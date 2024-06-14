<?php

/**
 * KCMS Social Like config
 * 
 * @package    KCMS
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
			 * Any custom name of entity to be liked, for example user's disputes
			 */
			'dispute' => [
				/**
				 * A model class name is being liked
				 */
				'ownerClass' => '',
				/**
				 * Public liking
				 */
				'isPublic' => false,
				/**
				 * Weather a user can revoke his like/dislike for an entity
				 */
				'isUpdatable' => false,
				/**
				 * Weither a user can dislike an entity
				 * By default, only like is allowed
				 */
				'allowDislike' => false,
				/**
				 * General liking entity description
				 */
				'title' => 'Dispute comment'
			],
		],
	],
);
