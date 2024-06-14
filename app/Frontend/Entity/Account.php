<?php

namespace App\Frontend;


use App\CompanyAdmin\Entity_Person;
use Kcms\Ecr\Scheme;
use Kcms\Ecr\SourceProperty;
use Kcms\Ecr\TypeString;


class SchemeEntity_Account extends \Kcms\Auth\SchemeEntity_Account
{
	#[SourceProperty] #[TypeString(length: 15)]
	public string $lang;
	#[SourceProperty(comment: 'Tax ident number')] #[TypeString(31)]
	public ?string $tin = '';
	
	
	protected function _build(Scheme $scheme)
	{
		parent::_build($scheme);
		
		$scheme->hasMany('companyPersons')->source(Entity_Person::class)->fKey('accountId');
	}
}


class Entity_Account extends \Kcms\Frontend\Entity_Account
{
	/**
	 * @return SchemeEntity_Account|Scheme
	 */
	public function scheme(): SchemeEntity_Account
	{
		return parent::scheme();
	}
}

