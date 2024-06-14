<?php

namespace App\Frontend;


use App\Mail\Letter;
use Kcms\Core\Request;


class Form_Account_Reset extends \Kcms\Auth\Form_Account_Reset
{
	
	protected function _doSendLetter()
	{
		return parent::_doSendLetter();
	}
}
