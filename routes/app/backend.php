<?php

namespace App\Backend;


use App\CompanyAdmin\Entity_Company;
use Kcms\Core\Arr;
use Kcms\Core\KCMS;
use Kcms\Core\Route;
use Kcms\Core\Route_Group;


Route::Setup('backend', function(Route_Group $routes){
	
	$profileRule = Arr::Implode(KCMS::Config('auth.frontend.controller.account.profile'), '|').'|personal';
	
	$routes->add(Controller_Account::RouteName())
		->path('account/<action>(/<profile>)')->controller(Controller_Account::class)
		->middleware('throttle:60,1') // 60 attempts per 1 minute
		->accessAllowed(true)
		->restrict('profile')->accessAllowed(false);
	
	$routes->add(Controller_User::RouteName())->actionPath('admins')->controller(Controller_User::class)->action('list')
		->map('item', \Kcms\Auth\Entity_User::class, ['id'=>'<id>|0', 'ownerClass' => function($route, $model){
			$class = \App\Backend\Entity_Account::class;
			return $class::Name();
		}]);
	
	$routes->add(Controller_Frontend_User::RouteName())
		->path('users(-<profile>)(/<action>(/<id>))')->controller(Controller_Frontend_User::class)->action('list')
		->rules(['profile' => $profileRule])
		->defaults(['profile' => null])
		->map('item', \Kcms\Auth\Entity_User::class, ['id'=>'<id>|0', 'ownerClass' => function($route, $model){
			$class = \App\Frontend\Entity_Account::class.ucfirst($route->param('profile'));
			return $class::Name();
		}]);
	
	// Example1 route
	// Copy and paste this code to start your own route
	// Make name of route in singular form.
	// $routes->add(\App\Backend\Controller_Frontend_Example1::RouteName())
	// 	->actionPath('example1')->controller(Controller_Frontend_Example1::class)->action('list')
	// 	->map('item', \App\Frontend\Entity_Example1::class, ['id'=>'<id>']);
	
	$routes->add('')->path('')->switch('user');
});


