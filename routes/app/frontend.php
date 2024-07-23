<?php

namespace App\Frontend;

use Kcms\Core\Route;
use Kcms\Core\Route_Group;


Route::Setup('frontend', function(Route_Group $routes){
	
	//$routes->enableCORS(/*['http://localhost:8080', 'http://localhost:3000', 'https://www.test-cors.org']*/true, ['GET', 'POST'], ['ajax','data','auth'], ['download']);
	
	$routes->add('account')->path('account/<action>(/<profile>)')->controller('Account')
		->accessAllowed(true)
		->restrict('profile')->accessAllowed(false);
	
	$routes->add('')->path('(<action>(/<id>))')->controller('Home')->action('default');
});
