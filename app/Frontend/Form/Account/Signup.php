<?php

namespace App\Frontend;


use App\Mail\Letter;


class Form_Account_Signup extends \Kcms\Auth\Form_Account_Signup
{
	
	protected function _doSendLetter()
	{
		return parent::_doSendLetter();
	}
	
}