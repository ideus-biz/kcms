<?php

namespace App\Frontend;


use App\Mail\Letter;


class Form_Account_Confirm extends \Kcms\Auth\Form_Account_Confirm
{
	
	protected function _doSendLetter()
	{
		return parent::_doSendLetter();
	}
}
