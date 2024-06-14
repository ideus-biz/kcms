<?php

namespace App\Frontend;


use App\Mail\Letter;


class Form_Account_Forgotten extends \Kcms\Auth\Form_Account_Forgotten
{
	
	protected function _doSendLetter()
	{
		return parent::_doSendLetter();
	}
}
