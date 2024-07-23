<?php

namespace App\Backend;


use App\CompanyAdmin\Entity_Company;
use Kcms\App\Entity_eMail_Letter_Template;
use Kcms\App\Entity_I18n;
use Kcms\App\Entity_Mobile_SMS_Message_Template;
use Kcms\Auth\Entity_Access_Group;
use Kcms\Auth\Entity_Role;
use Kcms\Core\Arr;
use Kcms\Core\KCMS;
use Kcms\Core\Locale;
use Kcms\Core\Route;
use Kcms\Core\Route_Group;


Route::Setup('backend', function(Route_Group $routes){
	
	$routes->withLang(count(Locale::Langs()) > 0);
	
	$routes->add(Controller_Account::RouteName())
		->path('account/<action>(/<profile>)')->controller(Controller_Account::class)
		->middleware('throttle:60,1') // 60 attempts per 1 minute
		->accessAllowed(true)
		->restrict('profile')->accessAllowed(false);
	
	$profileRule = Arr::Implode(KCMS::Config('auth.app.frontend.controller.account.profile'), '|');
	$routes->add(Controller_Frontend_User::RouteName())
		->path('users(-<profile>)(/<action>(/<id>))')->controller(Controller_Frontend_User::class)->action('list')
		->rules(['profile' => $profileRule])
		->defaults(['profile' => null])
		->map('item', \Kcms\Auth\Entity_User::class, ['id'=>'<id>|0', 'ownerClass' => function($route, $model){
			$class = \App\Frontend\Entity_Account::class.ucfirst($route->param('profile'));
			return $class::Name();
		}]);
	
	$routes->add(Controller_User::RouteName())->actionPath('administrators')->controller(Controller_User::class)->action('list')
		->map('item', \Kcms\Auth\Entity_User::class, ['id'=>'<id>|0', 'ownerClass' => function($route, $model){
			$class = \App\Backend\Entity_Account::class;
			return $class::Name();
		}]);
	
	$routes->add(Controller_eMail_LetterTemplate::RouteName())
		->actionPath('settings/email/letter-templates')->controller(Controller_eMail_LetterTemplate::class)->action('list')
		->map('item', Entity_eMail_Letter_Template::class, ['id' => '<id>|0']);
	
	$routes->add(Controller_Mobile_SMSTemplate::RouteName())
		->actionPath('settings/mobile/sms-templates')->controller(Controller_Mobile_SMSTemplate::class)->action('list')
		->map('item', Entity_Mobile_SMS_Message_Template::class, ['id' => '<id>|0']);
	
	$routes->add(Controller_I18n::RouteName())
		->actionPath('settings/internationalization')->controller(Controller_I18n::class)->action('list')
		->map('item', Entity_I18n::class, ['id' => '<id>|0']);
	
	$routes->add(Controller_Auth_Role::RouteName())
		->actionPath('auth/roles')
		->controller(Controller_Auth_Role::class)->action('list')
		->accessAllowed(false)
		->map('item', Entity_Role::class, ['id' => '<id>|0']);
	
	$routes->add(Controller_Auth_Access_Group::RouteName())
		->actionPath('auth/access/groups(/<parent>)')
		->rules(['parent' => '\d+'])
		->controller(Controller_Auth_Access_Group::class)->action('list')
		->map('item', Entity_Access_Group::class, ['id' => '<id>|0', 'parentId' => '<parent>'])
		->map('parent', Entity_Access_Group::class, ['id' => '<parent>|0'])
		->accessAllowed(false)
		->restrict('select_handler')->isXHR(true);
	
	// Example1 route
	// Copy and paste this code to start your own route
	// Make name of route in singular form.
	// $routes->add(\App\Backend\Controller_Frontend_Example1::RouteName())
	// 	->actionPath('example1')->controller(Controller_Frontend_Example1::class)->action('list')
	// 	->map('item', \App\Frontend\Entity_Example1::class, ['id'=>'<id>']);
	
	$routes->add('')->path('')->switch('user');
});


