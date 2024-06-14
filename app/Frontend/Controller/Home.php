<?php

namespace App\Frontend;


class Controller_Home extends Controller
{
	
	static public function SectionTitle(): string
	{
		return 'Dashboard';
	}
	
	
	static public function RouteName(): string
	{
		return '';
	}
	
	
	protected function _action_default()
	{
		
	}
}
