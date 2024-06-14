<?php

namespace App\Backend;


use Kcms\Active\ListBody;


/**
 * Class List Frontend Example1
 *
 * List processor for Example1 entity
 *
 * [!] Copy and paste this code to start your own list
 *
 */
class List_Frontend_Example1 extends ListBody
{
	public function __construct(\App\Frontend\Entity_Example1 $item)
	{
		parent::__construct($item);
	}
	
	
}
