<?php

namespace App\Backend;


use Kcms\Active\FormBody;
use Kcms\Active\FormEntity;


/**
 * Class Form Frontend Example1
 *
 * Form processor for Example1 entity
 *
 * [!] Copy and paste this code to start your own form
 *
 */
class Form_Frontend_Example1 extends FormBody
{
	
	public function __construct(\App\Frontend\Entity_Example1 $item)
	{
		parent::__construct();
		
		FormEntity::Instance('item', $this, $item);
		
		// Enable this code if the entity has naming ability
		// $this->item->element('title')->label('Title');
		// $this->item->element('alias')->label('Alias');
		
		// Enable this code if the entity has status ability
		// $this->item->element('isActive')->label('Active')->widget('checkbox');
	}
	
}
