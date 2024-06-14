<?php

namespace App\Frontend;


use Kcms\App\Controller_Auth;


class Controller_Account extends Controller
{
	// use AuthController;
	use Controller_Auth;
	
	
	static public function SectionTitle(): string
	{
		return 'Account';
	}
	
	
	static public function RouteName(): string
	{
		return 'account';
	}
	
	
}
