<?php

namespace App\Backend;


use Kcms\App\Menu;
use Kcms\Auth\Auth;
use Kcms\Core\Route;
use Kcms\Core\URL;


/**
 * App Backend Controller
 *
 * Класс-заглушка контроллера общего назначения для приложения Backend.
 * Все контроллеры приложения должны наследоваться от данного класса, чтобы иметь доступ к интерфейсу общих реализаций,
 * который доступен в классе-реализаторе \Kcms\Backend\Controller.
 *
 * @package    Kcms\Backend
 * @author     Andrew Potapov <andrew@ideus.biz>
 * @copyright  2010-2023  Andrew Potapov <andrew@ideus.biz> aka ultimus
 * @since      III.2023
 * @version    5.3.2023.0324
 * @version    5.5.2023.1106
 */
abstract class Controller extends \Kcms\Backend\Controller
{
	protected function _buildMainMenu(Menu $menu): void
	{
		if (Auth::Instance()->isAuthenticated())
		{
			$routes = Route::Group();
			$sections = [
				// Controller_eMail_LetterTemplate::class, Controller_Mobile_SMSTemplate::class
			];
			foreach ($sections as $v)
			{
				$routeName = $v::RouteName();
				$route = $routes[$routeName] ?? null;
				if (isset($route))
				{
					if (Auth::Instance()->hasAccess($route->handler()->name, $route->handler()->method))
					{
						$menu->addItem($routeName)
							->title($v::SectionTitle())
							->target(URL::Site($route->uri()))
							->isSelected($this->route->isLike($routeName));
					}
				}
			}
		}
		else
		{
			$menu
				->addItem('account')
				->title('Login')
				->target(Route::Url('account?action=login'))
				->isSelected($this->route->isLike('account?action=login'));
		}
		
		parent::_buildMainMenu($menu);
		
		if (Auth::Instance()->isAuthenticated())
		{
			$menu->addItem('account-logout')
				->title('Logout')
				->target(Route::Url('account?action=logout'));
		}
	}
	
	
	/**
	 * Callback called before every handler
	 * 
	 * [*] To get before handler for specific action - create protected _on_myaction() method in your specific controller that handles _action_myaction() method.
	 * 
	 * @return void
	 */
	/*protected function _beforeHandler()
	{
		parent::_beforeHandler();
	}*/
	
}
