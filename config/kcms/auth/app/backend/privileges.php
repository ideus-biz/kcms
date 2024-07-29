<?php

use Kcms\Auth\Auth;


return [
	Auth::PRIV_ALL => 'Allow create, change and delete',
	Auth::PRIV_UPDATE|Auth::PRIV_DELETE => 'Allow change and delete',
	Auth::PRIV_UPDATE => 'Allow change only',
	Auth::PRIV_READ => 'Allow view only'
];
