<?php

namespace Database\Seeders;

use App\Backend\Entity_Account;
use Illuminate\Database\Seeder;
use Kcms\Auth\Auth;
use Kcms\Auth\Entity_Access_Handler;
use Kcms\Auth\Entity_Role;
use Kcms\Core\FS_File_Text;
use Kcms\Ecr\Database;
use Kcms\Ecr\DB;


class KcmsInstall extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		echo 'KCMS Install'.PHP_EOL;
		echo 'Setting up authority system...'.PHP_EOL;
		Entity_Access_Handler::Instance()->set_title('Entire backend app')->set_application('backend')->set_controller('')->set_action('')->set_route('')
			->keepProperties()
			->find()->where('application', 'backend')->where('controller', '')->where('action', '')->where('route', '')
			->self()->restoreProperties()
			->save();
		
		Entity_Role::Instance()->set_application('frontend')->set_name(Auth::ROLE_NAME_USER)->set_description('User')->set_priority(Auth::ROLE_PRI_USER)
			->keepProperties()
			->find()->where('application', 'frontend')->and('name', Auth::ROLE_NAME_USER)
			->self()->restoreProperties()
			->save();
		$role = Entity_Role::Instance()->set_application('backend')->set_name(Auth::ROLE_NAME_ROOT)->set_description('Root')->set_priority(Auth::ROLE_PRI_ROOT)
			->set_allowPersonification(true)
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
			$u = 'root@localhost';
			$p = '1stEnter';
			echo 'There is no `root` account for Administration application.'.PHP_EOL;
			echo 'Creating: '.$u.':'.$p.PHP_EOL;
			$acc->user->role = $role;
			$acc->user
				->set_email($u)->set_username('root')->set_password($p)->set_isActive(true);
			$acc->save();
			echo 'Attention! Log into Administration application as `root` and change their email, password and personal data.'.PHP_EOL;
		}
		
		//
		$dataFile = FS_File_Text::Instance('database/seeders/kcmsInstallData.sql', DOCROOT);
		echo "Importing initial data from: {$dataFile->relativePath()}";
		if ($dataFile->isFile())
		{
			$this->_mysqlExec('START TRANSACTION;');
			$query = '';
			foreach ($dataFile as $v)
			{
				$v = trim($v);
				if ($v != '' && $v[0] != '#' && !str_starts_with($v, '-- '))
				{
					$query .= $v.PHP_EOL;
					if (str_ends_with($v, ';'))
					{
						echo 'Execute: '.$query.PHP_EOL;
						$this->_mysqlExec($query);
						$query = '';
					}
				}
			}
			$this->_mysqlExec('COMMIT;');
		}
    }
	
	
	private function _mysqlExec(string $query)
	{
		$conn = DB::Instance()->connection();
		$conn->statement($query);
	}
	
}
