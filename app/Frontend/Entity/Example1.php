<?php

namespace App\Frontend;


use Kcms\Ecr\Entity;
use Kcms\Ecr\Scheme;
use Kcms\Ecr\Scheme_Entity_Ability_Dated;
use Kcms\Ecr\Scheme_Entity_Ability_Named;
use Kcms\Ecr\Scheme_Entity_Ability_Status;
use Kcms\Ecr\SourceProperty;
use Kcms\Ecr\TypeKey;
use Kcms\Ecr\TypeKeyPrimary;
use Kcms\Ecr\TypeString;
use Kcms\Ecr\TypeTimestamp;


/**
 * Class Scheme_Entity_Company
 * 
 * Sync entity model with DB:
 * > php artisan ecr:sync --entity="\App\Frontend\Example1" [--rename="oldName1=newName1:oldName2=newName2"]
 * Drop entity's source:
 * > php artisan ecr:drop --entity="\App\Frontend\Example1"
 */
class SchemeEntity_Example1 extends Scheme
{
	#[SourceProperty]#[TypeKeyPrimary]
	public int $id;
	
	// Enable if the entity is an asset
	/*#[SourceProperty]#[TypeKey(name: 'owner', isUnique: true)]
	public int $ownerId;
	#[SourceProperty]#[TypeKey(name: 'owner', isUnique: true)]#[TypeString(length: 63)]
	public string $ownerClass;*/
	
	// Enable if the entity has Tree ability
	/*#[SourceProperty]#[TypeKey(name: 'parent')]
	public int $parentId;*/
	
	// Enable if the entity has Dated ability
	#[SourceProperty] #[TypeTimestamp] #[TypeKey(name: 'added')]
	public ?string $dateAdded;
	#[SourceProperty] #[TypeTimestamp]
	public ?string $dateUpdated;
	// #[SourceProperty] #[TypeTimestamp]
	// public ?string $dateRemoved;
	
	// Enable if the entity has Named ability
	#[SourceProperty]#[TypeString(length: 127)]#[TypeKey(isUnique: true)]
	public string $alias;
	#[SourceProperty]
	public string $title;
	
	// Enable if the entity has Status ability
	#[SourceProperty] #[TypeKey(name: 'status')]
	public ?bool $isActive = true;
	#[SourceProperty] #[TypeKey(name: 'status')]
	public ?bool $isRemoved = false;
	
	// Enable if the entity has Positioned ability
	#[SourceProperty]#[TypeKey]
	public int $position;
	
	
	protected function _build(Scheme $scheme)
	{
		parent::_build($scheme);
		
		$scheme->source('');
		
		Scheme_Entity_Ability_Dated::Instance($scheme);
		Scheme_Entity_Ability_Named::Instance($scheme);
		Scheme_Entity_Ability_Status::Instance($scheme);
		//Scheme_Entity_Ability_Filterable::Instance($scheme)->filter('isActive', 'boolval');
	}
}


abstract class Entity_Example1 extends Entity
{
	
}
