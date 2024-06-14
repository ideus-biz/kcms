<?php

namespace App\Frontend;


class Form_Account_Login extends \Kcms\Auth\Form_Account_Login
{
	public function init(): \Closure
	{
		return function(): static {
			parent::init()();
			
			return $this;
		};
	}
	
}