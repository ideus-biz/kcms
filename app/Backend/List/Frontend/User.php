<?php

namespace App\Backend;


use Kcms\Auth\Entity_User;


class List_Frontend_User extends \Kcms\Backend\List_Frontend_User
{
	public function __construct(Entity_User $item)
	{
		parent::__construct($item);
		
		// $this->element('ownerClass')->label('Application');
		$this->element('companies')->label('Company')->source(1)
			->widget()->renders->callback(
				fn()=>arr($this->id->model()->account->companyPersons->with('company')->field('company.title')->all()->toArray(null,'title'))->implode(', ').' ['.$this->id->model()->account->companyPersons->total().']'
			);
	}
	
	
}
