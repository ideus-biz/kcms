<?php

namespace Database\Seeders;

use App\Backend\Entity_Account;
use Illuminate\Database\Seeder;
use Kcms\Auth\Auth;
use Kcms\Auth\Entity_Role;


class KcmsInstall extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		Entity_Role::Instance()->set_application('frontend')->set_name(Auth::ROLE_NAME_USER)->set_description('User')->set_priority(Auth::ROLE_PRI_USER)
			->keepProperties()
			->find()->where('application', 'frontend')->and('name', Auth::ROLE_NAME_USER)
			->self()->restoreProperties()
			->save();
		$role = Entity_Role::Instance()->set_application('backend')->set_name(Auth::ROLE_NAME_ROOT)->set_description('Root')->set_priority(Auth::ROLE_PRI_ROOT)
			->keepProperties()
			->find()->where('application', 'backend')->and('name', Auth::ROLE_NAME_ROOT)
			->self()->restoreProperties()
			->save();
		Entity_Role::Instance()->set_application('backend')->set_name(Auth::ROLE_NAME_ADMIN)->set_description('Administrator')->set_priority(Auth::ROLE_PRI_ADMIN)
			->keepProperties()
			->find()->where('application', 'backend')->and('name', Auth::ROLE_NAME_ADMIN)
			->self()->restoreProperties()
			->save();
		Entity_Role::Instance()->set_application('backend')->set_name(Auth::ROLE_NAME_MANAGER)->set_description('Manager')->set_priority(Auth::ROLE_PRI_MANAGER)
			->keepProperties()
			->find()->where('application', 'backend')->and('name', Auth::ROLE_NAME_MANAGER)
			->self()->restoreProperties()
			->save();
		
		$acc = Entity_Account::Instance();
		if ($acc->find()->with('user')->where('username', 'root')->total() == 0)
		{
			echo 'There is no `root` account for Administration application.'.PHP_EOL;
			echo 'Creating: root@localhost:1stEnter'.PHP_EOL;
			$acc->user->role = $role;
			$acc->user
				->set_email('root@localhost')->set_username('root')->set_password('1stEnter')->set_isActive(true);
			$acc->save();
			echo 'Attention! Log into Administration application as `root` and change its password.'.PHP_EOL;
		}
    }
}
