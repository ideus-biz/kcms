<?php

use Kcms\Auth\Auth;


return [
	'filePath' => fn() => Auth::Instance()->account()->company->directory().'/shared',
];
