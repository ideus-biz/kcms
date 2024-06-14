<?php

/**
 * KCMS Auth Social config
 *
 * Application should overwrite this config file completely or partly.
 *
 * @package     KCMS v5 Auth module
 * @category    Configuration
 * @author      Andrey Potapov
 * @copyright   2010-2023    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license     LGPL
 * @since       X.2014
 * @version     3.2.2014.1003
 * @version     3.2.2016.0801 - `facebook.auth.personalInfo` is added
 * @version     3.2.2016.0929 - `google_plus` config
 * @version     3.2.2016.1026 - location is added
 * @version     3.2.2018.0606 - 'user_about_me' This permission was deprecated on April 4, 2018.
 * @version     5.3.2023.0328 - social config has moved in separate file
 */
return array(
	'network' => array(
		'Facebook' => array(
			/**
			 * Application ID
			 * Type: string
			 */
			'appId' => '',
			/**
			 * Application Secret
			 * Type: string
			 */
			'appSecret' => '',
			
			'auth' => array(
				/**
				 * Personal data to request
				 * Options: email user_location user_hometown manage_notifications manage_pages offline_access publish_actions read_friendlists read_insights read_mailbox read_page_mailboxes read_stream rsvp_event user_activities user_birthday user_education_history user_events user_friends user_games_activity user_groups user_interests user_likes user_photos user_relationship_details user_relationships user_religion_politics user_status user_videos user_website user_work_history
				 */
				'permissions' => 'email',
				
				/**
				 * https://developers.facebook.com/docs/graph-api/reference/user/
				 * For example: email, first_name, last_name, location, hometown
				 */
				'personalInfo' => 'email, first_name, last_name'
			),
			
			/**
			 * URL which handles this social network successful response.
			 * By default, it is @account?action=social_login&profile=facebook
			 * It is not recommended to change the URL in most cases.
			 * Change URL only in case of single application which cannot get access token by itself.
			 */
			'responseHandler' => '',
		),
		
		'GooglePlus' => array(
			/**
			 * Client ID
			 * Type: string
			 */
			'appId' => '',
			/**
			 * Client Secret
			 * Type: string
			 */
			'appSecret' => '',
			
			'auth' => array(
				'permissions' => 'profile email',
			),
			
			/**
			 * URL which handles this social network successful response.
			 * By default, it is @account?action=social_login&profile=googleplus
			 * It is not recommended to change the URL in most cases.
			 * Change URL only in case of single application which cannot get access token by itself.
			 */
			'responseHandler' => '',
		),
		
		'vkontakte' => array(
			/**
			 * Application ID
			 * Type: string
			 */
			'appId' => '',
			/**
			 * Application Secret
			 * Type: string
			 */
			'appSecret' => '',
			
			'auth' => array(
				/**
				 * Personal data to request
				 * Options: see https://vk.com/dev/permissions
				 */
				'permissions' => 'email'
			),
		),
		
		'linkedin' => array(
			/**
			 * Client ID
			 * Type: string
			 */
			'appId' => '',
			/**
			 * Client Secret
			 * Type: string
			 */
			'appSecret' => '',
			
			'auth' => array(
				/**
				 * Personal data to request
				 * Options: see https://developer.linkedin.com/docs/oauth2
				 * Options: see https://developer.linkedin.com/docs/fields/basic-profile
				 */
				'permissions' => 'r_emailaddress r_basicprofile w_share rw_company_admin',
				'profileFields' => 'firstName,email-address,lastName,id,picture-url,location'
			),
		),
	)
);
